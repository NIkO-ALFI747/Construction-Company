import os
import subprocess
import zipfile
import shutil
import tempfile
import requests

def download_and_extract_codeigniter(target_dir, ci_version="v4.5.1"):
    """
    Downloads a specific CodeIgniter 4 appstarter version and extracts it
    directly into the target_dir.
    """
    ci_release_url = f"https://github.com/codeigniter4/appstarter/archive/refs/tags/{ci_version}.zip"
    print(f"Downloading CodeIgniter 4 appstarter {ci_version} from {ci_release_url}...")
    try:
        response = requests.get(ci_release_url, stream=True)
        response.raise_for_status() # Raise an exception for bad status codes (e.g., 404)

        zip_file_path = os.path.join(target_dir, f"ci4_appstarter_{ci_version}.zip")
        with open(zip_file_path, 'wb') as f:
            for chunk in response.iter_content(chunk_size=8192):
                f.write(chunk)

        print(f"Extracting CodeIgniter to {target_dir}...")
        with zipfile.ZipFile(zip_file_path, 'r') as zip_ref:
            zip_ref.extractall(target_dir)

        # The extracted folder will typically have a name like 'appstarter-4.5.1'
        extracted_folder_name = ""
        for item in os.listdir(target_dir):
            if item.startswith("appstarter-") and os.path.isdir(os.path.join(target_dir, item)):
                extracted_folder_name = item
                break

        if not extracted_folder_name:
            raise FileNotFoundError("Could not find extracted CodeIgniter appstarter folder.")

        # Move contents from the extracted folder to the target_dir directly
        # This makes target_dir the CI project root (containing app/, public/, system/, etc.)
        source_path = os.path.join(target_dir, extracted_folder_name)
        for item in os.listdir(source_path):
            shutil.move(os.path.join(source_path, item), target_dir)

        # Remove the original extracted folder and the downloaded zip file
        shutil.rmtree(source_path)
        os.remove(zip_file_path)

        print(f"CodeIgniter {ci_version} extracted and moved to '{target_dir}' successfully.")
        return target_dir # Return the path to the CI project root
    except requests.exceptions.RequestException as e:
        print(f"Error downloading CodeIgniter: {e}")
        raise
    except zipfile.BadZipFile as e:
        print(f"Error extracting ZIP file: {e}")
        raise
    except Exception as e:
        print(f"An unexpected error occurred during CI download/extraction: {e}")
        raise

def create_boilerplate_zip(output_zip_name, source_dir):
    """
    Creates a ZIP file from the contents of the source directory.
    The ZIP will contain the entire project structure ready for use.
    """
    print(f"Creating ZIP file '{output_zip_name}' from '{source_dir}'...")
    with zipfile.ZipFile(output_zip_name, 'w', zipfile.ZIP_DEFLATED) as zipf:
        for root, dirs, files in os.walk(source_dir):
            for file in files:
                file_path = os.path.join(root, file)
                # Calculate the path relative to source_dir for the zip archive
                arcname = os.path.relpath(file_path, source_dir)
                zipf.write(file_path, arcname)
    print(f"ZIP file '{output_zip_name}' created successfully.")

def main():
    """
    Main function to orchestrate the generation of the CodeIgniter Docker boilerplate.
    """
    zip_filename = "codeigniter-docker-boilerplate.zip"
    temp_project_root = None # Initialize to None for robust cleanup

    try:
        # Create a temporary directory to assemble the entire project structure
        temp_project_root = tempfile.mkdtemp()
        print(f"\nWorking in temporary directory: {temp_project_root}")

        # Step 1: Download and extract a fresh CodeIgniter 4 appstarter into temp_project_root
        # This will make temp_project_root the base CI project (containing app/, public/, spark, composer.json, etc.)
        ci_project_path = download_and_extract_codeigniter(temp_project_root, ci_version="v4.5.1")

        source_init_setup_dir = os.path.join(os.getcwd(), "init_setup")
        if not os.path.exists(source_init_setup_dir):
            print(f"Error: Source directory '{source_init_setup_dir}' not found.")
            print("Please ensure 'init_setup' directory exists in the same location as generate_boilerplate.py.")
            exit(1)

        # Define the full project source directory on the host (relative to where the script is run)
        source_full_project_setup_dir = os.path.join(os.getcwd(), "full_project_setup")
        if not os.path.exists(source_full_project_setup_dir):
            print(f"Error: Source directory '{source_full_project_setup_dir}' not found.")
            print("Please ensure 'full_project_setup' directory exists in the same location as generate_boilerplate.py.")
            exit(1)

        # Step 2.1: Overlay/Copy contents from the 'init_setup' directory into the fresh CI project
        # This will overwrite default CI files with your customized versions (e.g., composer.json, .env, Dockerfile, etc.)
        print(f"Overlaying contents from '{source_init_setup_dir}' onto '{ci_project_path}'...")
        for item in os.listdir(source_init_setup_dir):
            s = os.path.join(source_init_setup_dir, item)
            d = os.path.join(ci_project_path, item)
            if os.path.isdir(s):
                # Use dirs_exist_ok=True for Python 3.8+ to merge directories
                shutil.copytree(s, d, symlinks=False, ignore=None, dirs_exist_ok=True)
            else:
                shutil.copy2(s, d)
        print("Finished overlaying 'init_setup' contents.")

        # Step 2.2: Overlay/Copy contents from the 'full_project_setup' directory into the fresh CI project
        # This will overwrite default CI files with your customized versions
        print(f"Overlaying contents from '{source_full_project_setup_dir}' onto '{ci_project_path}'...")
        for item in os.listdir(source_full_project_setup_dir):
            s = os.path.join(source_full_project_setup_dir, item)
            d = os.path.join(ci_project_path, item)
            if os.path.isdir(s):
                shutil.copytree(s, d, symlinks=False, ignore=None, dirs_exist_ok=True)
            else:
                shutil.copy2(s, d)
        print("Finished overlaying 'full_project_setup' contents.")

        # Step 3: Run Composer update in the combined project root
        # This installs/updates vendor dependencies, including codeigniter4/framework/system
        print(f"Running 'composer update' in {ci_project_path}...")
        try:
            subprocess.run(["composer", "update", "--no-dev", "--no-interaction"], cwd=ci_project_path, check=True, text=True, capture_output=True)
            print("Composer update completed successfully.")
        except FileNotFoundError:
            print("Error: Composer executable not found. Please ensure Composer is installed and accessible in your PATH.")
            print("You can download it from getcomposer.org")
            exit(1)
        except subprocess.CalledProcessError as e:
            print(f"Error running Composer update: {e}")
            print(f"STDOUT: {e.stdout}")
            print(f"STDERR: {e.stderr}")
            print("Please ensure your project directory has write permissions and check composer.json.")
            exit(1)

        # Step 5: Create the final ZIP file from the assembled project in the temporary directory.
        create_boilerplate_zip(zip_filename, ci_project_path)

        print("\nBoilerplate generation complete!")
        print(f"Your CodeIgniter Docker boilerplate has been created as '{zip_filename}'.")
        print("\n--- Next Steps ---")
        print(f"1. Extract '{zip_filename}' to your desired project directory.")
        print("2. Navigate to the extracted project directory in your terminal.")
        print("3. Run `docker-compose up --build -d` to build the Docker images and start containers.")
        print("4. Access your CodeIgniter app in your browser at `http://localhost:8080`")
        print("5. Access phpMyAdmin at `http://localhost:8081`")
        print("6. Visit `http://localhost:8080/setup/seed` in your browser to initialize the database.")

    except Exception as e:
        print(f"\nAn error occurred during boilerplate generation: {e}")
    finally:
        # Step 6: Clean up the temporary directory to remove all intermediate files.
        if temp_project_root and os.path.exists(temp_project_root):
            print(f"\nCleaning up temporary directory: {temp_project_root}")
            shutil.rmtree(temp_project_root)
        print("Cleanup complete.")

if __name__ == "__main__":
    main()

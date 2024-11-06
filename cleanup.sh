#!/bin/bash

# list of root folders to remove
root_folders_to_remove=(
  "node_modules"
  "out"
  ".turbo"
)

# list of app, packages and service folders to remove
app_package_and_service_folders_to_remove=(
  ".nuxt"
  "vendor"
  "node_modules"
  "dist"
  ".cache"
  ".output"
  ".turbo"
  "coverage"
)

# list of app, packages and service files to remove
app_package_and_service_files_to_remove=(
  "tsconfig.lib.tsbuildinfo"
)

# remove folders in root
for folder in "${root_folders_to_remove[@]}"
do
  if [ -d "$folder" ]; then
    echo "Removing $folder"
    rm -rf $folder
  fi
done

# remove folders in apps, packages and services
for folder in apps/*/ packages/*/ services/*/
do
  for remove_folder in "${app_package_and_service_folders_to_remove[@]}"
  do
    if [ -d "$folder$remove_folder" ]; then
      echo "Removing $folder$remove_folder"
      rm -rf $folder$remove_folder
    fi
  done

  for remove_file in "${app_package_and_service_files_to_remove[@]}"
  do
    if [ -f "$folder$remove_file" ]; then
      echo "Removing $folder$remove_file"
      rm -rf $folder$remove_file
    fi
  done
done
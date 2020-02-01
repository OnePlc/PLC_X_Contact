#!/usr/bin/env python
# -*- coding: utf-8 -*-
import sys
import os
import shutil
import glob
import errno, stat
import re
import pkg_resources

"""
createmodulefromskeleton.py - Create your own module form a oneplace Skeleton
 Renames all modules and cleanup code structure
 Usage: createmodulefromskeleton.py path/to/module modulename

 @author Verein onePlace
 @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 @license https://opensource.org/licenses/BSD-3-Clause
 @version 1.0.3
 @since 1.0.0

 # Changelog
    1.0.3: add new parameter [version]
           replace all since tags
    1.0.2: replace @since tag in module.php
           add -v verbose log + better output
"""

DEBUG = False

# Remove Files and Folders (wildcard only for files)
aToDelFiles = []
aToDelFiles.append("/data/*.sh")
aToDelFiles.append("/data/*.ps1")
aToDelFiles.append("/data/*.py")
aToDelFiles.append("/view/layout/*default.phtml")
aToDelFiles.append("/CHANGELOG.md")
aToDelFiles.append("/mkdocs.yml")

aToDelDirs = []
aToDelDirs.append("/.git")
aToDelDirs.append("/docs/book")

# Whitelist from renaming
aWhiteList = []
aWhiteList.append("/language/")

sSkeletonName = "Skeleton"
sSkeletonVersion = ""
sModuleVersion = "1.0.0"
sVersionFile = "Module.php"

def printHelp():
  print("Create a new Module based on the current PLC_X_Skeleton")
  print("Run it directly inside /data/")
  print("Using:")
  print(sys.argv[0] + " path/to/module modulename [x.x.x] [-v]")
  exit(1)


def remove_readonly(func, path, exc_info):
    """
    Error handler for ``shutil.rmtree``.

    If the error is due to an access error (read only file)
    it attempts to add write permission and then retries.

    If the error is for another reason it re-raises the error.

    Usage : ``shutil.rmtree(path, onerror=onerror)``
    """
    import stat
    if not os.access(path, os.W_OK):
        # Is the error an access error ?
        os.chmod(path, stat.S_IWUSR)
        func(path)
    else:
        raise

# Convert Module Name for Skeleton to skeleton or vs
def getModulname(name, upper = True):
  if(name[0].islower() and upper):
    name = name[0].upper() + name[1:]
  if(name[0].isupper() and not upper): 
    name = name[0].lower()+ name[1:]
  return name


# check if module name is provided
if len(sys.argv) < 3 :
  printHelp()

# parse -v param
# TODO implement arg manager
if len(sys.argv) >= 4 :
  for argv in sys.argv :
    if argv == "-v":
      DEBUG = True
    try:
      if re.search(r'[\d.]+', argv) and len(argv) < 10:
        sModuleVersion = argv
        print("Modul Version " + sModuleVersion)
    except IOError:
        print()



sScriptPath = os.path.realpath(__file__)
sModulePath = sys.argv[1]
sModuleName = sys.argv[2]
iChangeCount = 0

# check if path is occupied
if os.path.exists(sys.argv[1]):
  print("Module already exists... move ,delete or rename your Module at " + sModulePath)
  #print(sModulePath)
  shutil.rmtree(sModulePath, ignore_errors=False, onerror=remove_readonly)
  exit(1)
  
#check if the context is right
try:
  f = open("../src/Module.php", "r")
  for line in f:
    if line.find("VERSION") > 0:
      sSkeletonVersion = re.search(r'(?<=VERSION )*[\d.]+', line).group(0)
      print("Skeleton Version is " + sSkeletonVersion)
except IOError:
  print("Error wrong context " + sModulePath + "\n")
  printHelp()



print("Creating oneplace module at " + sModulePath + "\n")
# copy skeleton
try:
  shutil.copytree("../", sModulePath)
except IOError as err:
  print("Cant create module "+ "\n" + format(err))



# Remove folders
for dir in aToDelDirs:
  try:
    if DEBUG :
      print("delete " + sModulePath+dir)
    shutil.rmtree(sModulePath+dir, ignore_errors=False, onerror=remove_readonly)
    iChangeCount += 1
  except:
    print("Error while deleting file : ", sModulePath+dir)
    exit(2)

print(" " + str(iChangeCount) + " folders deleted")
iChangeCount=0

# delete files
for fileList in aToDelFiles:
  for filePath in glob.glob(sModulePath+fileList):
    try:
      if DEBUG :
        print("delete " + filePath)
      iChangeCount += 1
      os.remove(filePath)
    except:
      print("Error while deleting file : ", filePath)
      exit(2)

print(" " + str(iChangeCount) + " files deleted")
iChangeCount=0

sSkel_s = getModulname(sSkeletonName,False)
sSkel_S = getModulname(sSkeletonName,True)

sModul_s = getModulname(sModuleName,False)
sModul_S = getModulname(sModuleName,True)

# this while loop is only for folder recursive renaming issue
bFinish = False
while not bFinish:
  bFinish = True
  # rename all folders
  for root, dirs, files in os.walk(sModulePath):
    path = root.split(os.sep)
    for dir in dirs:
      sSource = dir
      # rename all Folders from skeleton to moduleName
      if sSkel_s in dir:
        sDest = dir.replace(sSkel_s,sModul_s)
        if DEBUG :
            print("rename  " + os.path.join(root,sSource) + " to " + os.path.join(root,sDest))
        os.rename(os.path.join(root,sSource), os.path.join(root,sDest))
        iChangeCount += 1
        bFinish = False # dirty solution
        break
      # rename all Folders from Skeleton to ModuleName
      if sSkel_S in dir:
        sDest = dir.replace(sSkel_S,sModul_S)
        if DEBUG :
            print("rename" +  sSource + " to " + sDest)
        bFinish = False # dirty solution
        os.rename(sSource, sDest)
        iChangeCount += 1
        break

print(" " + str(iChangeCount) + " folders renamed")
iChangeCount=0

#rename all files
ignore=False
for root, dirs, files in os.walk(sModulePath):
  # rename all Files from Skeleton to ModuleName
  for file in files:
    sSource = file
    # ignore whitelisted files
    for url in aWhiteList:
      path = os.path.join(root,sSource)
      if path.find(url) > 0:
        print("ignore " + path)
        ignore = True

    if ignore:
      ignore=False
      continue

    if sSkel_s in file:
      sDest = file.replace(sSkel_s, sModul_s)
      if DEBUG :
        print("rename  " + os.path.join(root,sSource) + " to " + os.path.join(root,sDest))
      os.rename(os.path.join(root,sSource), os.path.join(root,sDest))
      iChangeCount += 1

      # rename all Folders from Skeleton to ModuleName
    if sSkel_S in file:
      sDest = file.replace(sSkel_S, sModul_S)
      if DEBUG:
        print("rename  " + os.path.join(root,sSource) + " to " + os.path.join(root,sDest))
      os.rename(os.path.join(root,sSource), os.path.join(root,sDest))
      iChangeCount += 1

print(" " + str(iChangeCount) + " files renamed")
iChangeCount=0

# all renaming inside files happens here:
for root, dirs, files in os.walk(sModulePath):
  # rename all Files from Skeleton to ModuleName
  for file in files:
    sSource = os.path.join(root,file)
    sSourceTemp = os.path.join(root,file + "_temp")

    # ignore whitelisted files
    for url in aWhiteList:
      if sSource.find(url) > 0:
        ignore = True

    if ignore:
      ignore = False
      continue

    fp = open(sSource,"r")
    fpW = open(sSourceTemp,"w")
    # search an replace inside each file
    # look for versions and set it to 1.0.0
    line_count = 0
    sVersionTag ="@version"
    sSinceTag ="@since"
    try:
      for line in fp:
        line_count=line_count+1
        # not a beauty - but works
        if sSource.find(sVersionFile) > 0 and line.find("VERSION") > 0:
          if DEBUG :
            print("set " + sVersionTag + " to " + sModuleVersion + " in " + sSource + " at Line " + str(line_count))
          line="    const VERSION = '" + sModuleVersion + "';\n"

        elif sSource.find(sVersionFile) > 0 and line.find(sVersionTag) > 0:
          if DEBUG :
            print("set " + sVersionTag + " to " + sModuleVersion + " in " + sSource + " at Line " + str(line_count))
          line = line[:line.find(sVersionTag) + len(sVersionTag)] + " " + sModuleVersion + "\n"

        elif line.find(sSinceTag) > 0:
          sSinceVersion = re.search(r'[\d.]+', line).group(0)
          if pkg_resources.parse_version(sSinceVersion) > pkg_resources.parse_version(sModuleVersion) :
            if DEBUG :
              print("set " + sSinceTag + " to " + sModuleVersion + " in " + sSource + " at Line " + str(line_count))
            line = line[:line.find(sSinceTag) + len(sSinceTag)] + " " + sModuleVersion + "\n"

        # replace skeleton name
        sOrig=line
        line = line.replace(sSkel_S, sModul_S)
        line = line.replace(sSkel_s, sModul_s)
        if sOrig != line :
          if DEBUG :
            print(sSource + " renaming at Line: " + str(line_count))
          iChangeCount += 1
        fpW.write(line)
    except Exception as e:
      print(sModulePath + " Error while renaming file : " + dir + " " + str(e))
      exit(2)


    fp.close()
    os.remove(sSource)
    fpW.close()
    os.rename(sSourceTemp, sSource)

print(" " + str(iChangeCount) + " files renamed")
iChangeCount=0

print("\nModule successfully created at: " + sModulePath)

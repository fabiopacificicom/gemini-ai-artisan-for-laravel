# Sample package usage -

## HOW TO USE

Clone the repo locally and assign to the package your desider name
for example:

```bash
git clone git@bitbucket.org:fbhood/packaged-for-laravel.git PacificDev/TerminalAssistant
```

The above command will scaffold the repo inside PacificDev/TerminalAssistant.
Search and replase all occurrences of SamplePackage and replace with the name you chosed above
PacificDev/TerminalAssistant in my case.

### Update the autoloader

in the laravel app, find the main composer.json file and under the autoload psr-4 key place
This two lines.

```json
  "PacificDev\\TerminalAssistant\\": "src/",
  "PacificDev\\TerminalAssistant\\Commands\\": "src/app/Commands/"
```

These are the tow base folders mapped by the autoloader, you might add more as necessary.
At this point you should be able to see two artian commands under `pacificdev:`
update the code as you see fits your usecase.

## DEVELOPMENT ONLY

This repo is intended as sample base structure to create
new laravel packages.

Inside the composer.json file add your development package repository under repositories and add its name under requirements.

```json

    "repositories": [
        {
            "type": "vcs",
            "url": "git@bitbucket.org:fbhood/packaged-for-laravel.git"

        }
    ],
    "require": {
        "pacificdev/terminal-assistant":"dev-main"
    },
```

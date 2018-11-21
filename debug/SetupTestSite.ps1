# Set up test website and install PicoMailFormsPlugin

$appDirectory = 'TestApp';

$pluginDirectory = "$PSScriptRoot\..";
$appDirectory = "$PSScriptRoot\..\..\$appDirectory";

if (Test-Path $appDirectory) {
    Remove-Item -Recurse -Force $appDirectory;
}
New-Item -ItemType Directory $appDirectory;

cd $appDirectory;

composer create-project picocms/pico-composer .
composer require jflepp/picopagefolders

Remove-Item -Recurse -Force $appDirectory\plugins\picopagefolders
New-Item -ItemType Directory $appDirectory\plugins\picopagefolders;
Copy-Item $pluginDirectory\* $appDirectory\plugins\picopagefolders -Recurse -Force

Copy-Item $PSScriptRoot\TestData\* $appDirectory -Recurse -Force

php -S localhost:80

# Multiple file upload with PHP and MySQL - Uploading and Downloading

This small example shows how to upload and download files in PHP.

## It's recommended that you use Composer to install UDFiles.

Run this command from the directory in which you want to install your new UDFiles application.

    composer require dheeyi/ud-files dev-master

That's! Now go upload and download files.

## Usage
### Config default data [settings.php]
        
    return [
        'settings' => [
            // Directory uploaded settings
            'upload_path' => __DIR__ . '/../files',
    
            // Database settings
            'database' => [
                    'driver' => 'mysql',
                    'host' => '127.0.0.1',
                    'database' => 'cegos',
                    'username' => 'root',
                    'password' => 'sample',
                    'collation' => 'utf8_general_ci',
                    'prefix' => ''
            ],
    
            // Name App settings
            'nameApp' => 'Upload Files in PHP',
            // Display erros settings
            'displayErrors' => false,
        ],
    ];

### Config App [init App]
    require __DIR__ . '/../vendor/autoload.php';
    
    use UDFiles\App\App;
    use UDFiles\FileManager\File;
    
    /**
     * Initialize the App
     * Basic Example Usage
     * Default parameters must be declared (settings.php)
     */
    $settings = require __DIR__ . '/../src/settings.php';
    $app = new App($settings);
    
### Create Instance Class [File]
    /**
     * Create an instance of class File
     */
    $file = new File($_FILES['file']);

### Usage methods [functions example]
    /**
     * Default validations are disabled ['validateExtension' => false, 'validateSize' => false, 'size' => '0'];
     * Default Extensions ['jpeg', 'jpg', 'png', 'pdf', 'txt'];
     *
     * If we want to add a new extension
     * $file->addExtension('png'); or $file->setExtensions(['pdf', 'jpg']);
     */
    $file->setValidate(['validateExtension' => true, 'validateSize' => true, 'size' => 100000]);
    
    //Set the directory where files are uploaded
    $file->setPathUpload($app->getSetting('upload_path'));
    
    
    //Upload File
    $file->uploadFile($file->getFileName());
    
    //Move de file to other directory
    $file->moveFile($file->getFileName(), '/opt/goo/UDFiles/classes');
    
    //Set new directory where files are uploaded
    $file->setPathUpload('/opt/goo/UDFiles/classes');
    
    //Rename File
    $file->renameFile($file->getFileName(), '/opt/goo/UDFiles/classes/newname.pdf');
    
    //Download File
    $file->downloadFile($file->getFileName());
    
    //Download File Inline
    $file->downloadFileInline($file->getFileName(), 'application/pdf', true, '/opt/goo/UDFiles/classes');
    
    //Delete File
    $file->deleteFile($file->getFileName());
    
    //Move File
    $file->moveFile($file->getFileName(), '/opt/goo/UDFiles/classes');
    
    //Delete File (send new path directory)
    $file->deleteFile($file->getFileName(), '/opt/goo/UDFiles/classes');
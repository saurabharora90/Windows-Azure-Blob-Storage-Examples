#Windows Azure Blob Storage Examples

Examples showing how to use the Windows Azure blob storage using the Azure SDK for PHP. The guide on [How to use the Blob service from PHP] (http://www.windowsazure.com/en-us/develop/php/how-to-guides/blob-service/) only shows the basic operation on the Blob Storage. This guide shall extend on them to show you how to use the other avaliable functions, especially how to upload and retrive large media files using the Azure PHP SDK which wraps the REST API

>Note: I wrote these samples when the Azure SDK for PHP was new and most of the example I could find were based on the [Old SDK] (http://phpazure.codeplex.com/)

**All the example are assuming you have downloaded the Azure SDK For PHP from [GitHub] (https://github.com/WindowsAzure/azure-sdk-for-php) and set up a storage account and a container for blob storage by following [this guide] (http://www.windowsazure.com/en-us/develop/php/how-to-guides/blob-service/).**

*These files are just examples. You can optimize and modify them and add client side functionality as you like.*

####php.ini
This file conatins some of the PHP settings you might need to modify to be able to upload multiple large files to the server and to the blob storage service.

####splitANDupload.php
This file shows you how to split a large file and upload it block by block and then combine all the blocks into a blob. Read the comments in the file to have a better understanding of what is happening.
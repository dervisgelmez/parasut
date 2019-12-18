
# Parasut v4 Client

## Install
    composer require dervis/parasut
    
## Guide 

Configuration

    include 'vendor/autoload.php';
    use Parasut\Client;
  
    $parasut = new Client([
          "client_id" => "...",
          "username" => "...",
          "password" => "****",
          'company_id' => "...",
          "grant_type" => "password",
          "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob"
    ]);

Authorize

    $parasut->authorize();
   
   Use Services
   
	$parasut->open('service_name');
	
Service name list
* Account
* Category
* Contact
* Employee
* Invoice
* Product
* Trackable
 
 > Services have `unique` and `general` methods, open method is called to use services

    $parasut->open('service_name')->methods;

* Account
* Category
* Contact
* Employee
* Invoice
* Product
* Trackable
 
 General Methods
 * show()
 
        ->show($filter:array, $page:default(1), $size:default(15));
 * find()
 
        ->find($id:requirement);
 * create()
 
        ->create($data:requirement);
 * update()
 
        ->update($id:requirement, $data:requirement);
 * delete()
 
        ->delete($id:requirement);

  
 Unique Methods
* Account
    * General Methods
    * transactions()
* Category
    * General Methods
* Contact
    * General Methods
* Employee
    * General Methods
    * archive()
    * unArchive()
* Invoice
    * General Methods
    * archive()
    * eArchives()
    * eInvoices()
    * cancel()
    * pay()
    * pdf()
    * recover()
    * unArchive()
* Product
    * General Methods
* Trackable
    * checkStatus()
    
 
 

> [Path Internet Solution](https://www.path.com.tr/) [[Derviş Gelmez](https://twitter.com/dervisgelmez)]



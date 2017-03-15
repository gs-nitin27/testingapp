<?php
class DatabaseConnection{

	var $vServer           = "localhost";                ///< database server name
	var $vUsername         = "root";                      ///< database user name    
	var $vPassword         = "root";                           ///< database password 
	var $vDatabasename     = "get_sporty";                       ///< database name  
	var $vPort             = "3306";                             ///< port number
	var $vSocket           = "";                             ///< socket
	/*var $vServer           = "db2499.perfora.net";                ///< database server name
	var $vUsername         = "dbo333343075";                      ///< database user name    
	var $vPassword         = "diamond";                           ///< database password 
	var $vDatabasename     = "db333343075";                       ///< database name  
	var $vPort             = "3306";                             ///< port number
*/
	var $vConnection;                                             ///< database connection link
	
     /**
     * @startcomment
     * Purpose: Constructor
     *
     * Input Params: None
     *  
	 *
     * Output Params:
     *  1. $vConnection - obj - database connection link
     * 
     * Return Value: None
     *  
     *
     * Notes:
	 *
     * @endcomment
     */
     
     
     						
				// for test				
								
	/* var $vServer  = "db395110734.db.1and1.com";                ///< database server name
	var $vUsername         = "dbo395110734";                      ///< database user name    
	var $vPassword         = "1234567";                           ///< database password 
	var $vDatabasename     = "db395110734";                       ///< database name  
	var $vPort             = "3306";	*/					   ///< port number
	                                  
												
	 
	public function __construct ( )
	{
	  	
	}
	
	 /**
     * @startcomment
     * Purpose: To Create a Connection with Database
     *
     * Input Params:
     *  1.
	 *
     * Output Params:
     *  1. $vConnection - object - database connection link
     * 
     * Return Value:
     *  1. $vConnection - object - database connection link
     *  
     *
     * Notes:
	 *
     * @endcomment
     */
	 
	public function createConnection ( )
	{
		$this->vConnection = mysqli_connect(
	  							$this->vServer,  
	  							$this->vUsername,  
	  							$this->vPassword, 
	  							$this->vDatabasename
	  						);
							
		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		} 
						
	    return 	$this->vConnection;				
	}
	
	 /**
     * @startcomment
     * Purpose: To Close a Connection with Database
     *
     * Input Params: None
     *  
	 *
     * Output Params: None
     *  
     * 
     * Return Value: None
     *   
     * Notes:
	 *
     * @endcomment
     */
	 
	public function closeConnection ( )
	{
		mysqli_close ( $this->vConnection );
	}
	
	
	
	public function getServer()
	{
	  //return $this->vServer.":".$this->vSocket; 
               return $this->vServer; 
	}
    public function getUser()
	{
	  return $this->vUsername;  
	}
    public function getPassword()
	{
	  return $this->vPassword;  
	}
    public function getDatabase()
	{
	  return $this->vDatabasename;  
	}
	 public function getSocket()
	{
	  return $this->vSocket ;  
	}
	
     public function getPort()
	{
	  return $this->vPort;  
	}
	
}
?>
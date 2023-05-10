<?php
/*
 * Bookmark Class
 * Used to run functions on all bookmarks
 * Get Bookmarks
 * Add Bookmarks
 * Delete Bookmarks
 * Add Visit
 * Usage Example to set ID and BookmarkID:
 *     $bookmark = Bookmark::create()->setID($sess['inputs]->data->id)->setBookmarkID($_POST['BookmarkID]);
 * Call to deleteBookmarks()
 *     $bookmark->deleteBookmark();
 */
 class Bookmark {
    protected $_url;
    protected $_displayName;
    protected $_id;
    protected $_bookmarkID;
    protected $_searchTerm;
    protected $_shared;

#region "Constructor"
    function __construct() {}
    public static function create() {
        return new self();
    }
    public function setURL($url = "https://www.uwsp.edu") {
        $this->_url = $url;
        return $this;
    }
    public function setDisplayName($displayName = "UWSP") {
        $this->_displayName = $displayName;
        return $this;
    }
    public function setID($id = 0) {
        $this->_id = $id;
        return $this;
    }
    public function setBookmakID($bookmarkId = 0) {
        $this->_bookmarkID = $bookmarkId;
        return $this;
    }
    public function setSearchTerm($searchTerm = "UWSP"){
        $this->_searchTerm = $searchTerm;
        return $this;
    }
    public function setShared($shared = true){
        $this->_shared = $shared;
        return $this;
    }
#endregion
#region "Add Bookmark"    
    function addBookmark($client, $sess)
    {
        require_once(__DIR__ . "/../../../tos.php");

        if(count($sess['results']) > 0){
            $sess['results'][] = "Error Has Occured";            
        }
        
        $data = array("url" => $this->_url, "displayname" => $this->_displayName, "user_id" => $this->_id, "shared" => $this->_shared);
        $action = "addbookmark";
        $fields = array(
            "apikey" => APIKEY,
            "apihash" => APIHASH,
            "data" => $data,
            "action" => $action,
        );

        $client->setPostFields($fields);
        $returnValue = $client->send();
        $obj = json_decode($returnValue);

        //possibly make a function to run this error handling
        if (!property_exists($obj, "result")) {
            $sess['results'][] = "Error has occured";
        } 
        
        if ($obj->result == "Success") {
            $sess['results'][] = "Success";
        } else {
            $sess['results'][] = "Error has occured";
        }
        return $sess['results'];
    }//end function 
#endregion    
#region "Delete Bookmark"
    function deleteBookmark($client, $sess)
    {
        require_once(__DIR__ . "/../../../tos.php");

        if(count($sess['results']) > 0){
            $sess['results'][] = "Error Has Occured";            
        }

        $data = array("bookmark_id" => $this->_bookmarkID, "user_id" => $this->_id);
        $action = "deletebookmark";
        $fields = array(
            "apikey" => APIKEY,
            "apihash" => APIHASH,
            "data" => $data,
            "action" => $action,
        );

        $client->setPostFields($fields);
        $returnValue = $client->send();
        $obj = json_decode($returnValue);

        if (!property_exists($obj, "result")) {
            $sess['results'][] = "Error has occured";
        }

        if ($obj->result == "Success") {
            $sess['results'][] = "Success";

        } else {
            $sess['results'][] = "Error has occured";

        }
        return $sess['results'];
    }
#endregion
#region "Get Bookmark"
    function getBookmarks($client, $sess) //pass in client and session url 
    {
        //will need to check if they want the bookmark to show or not.
        require_once(__DIR__ . "/../../../tos.php");
        $sess['bookdata'] = array();

        $data = array("user_id" => $this->_id, "order_dir" => "DESC");
        $action = "getbookmarks";
        $fields = array(
            "apikey" => APIKEY,
            "apihash" => APIHASH,
            "data" => $data,
            "action" => $action
        );
        $client->setPostFields($fields);

        $returnValue = $client->send();

        $obj = json_decode($returnValue);

        if (!property_exists($obj, "result")) {
            $sess['results'][][] = "Error has occured"; //return this rather than redirect. try to always return an array
            return $sess['results'];
        }

        if ($obj->result == 'Success') {

            $urlList = $obj->data;
            if (!is_array($urlList) || count($urlList) == 0) {
                $sess['bookdata'][] = '<span class="bookmarkList">No Bookmarks Found</span>';
            } else {
                $sess['bookdata'][] = $urlList; 
            }
            return $sess['bookdata'];
        }

    } //end of function
#endregion
#region "Add Visit"
    function addVisit($client, $sess)
    {
        require_once(__DIR__ . "/../../../tos.php");
        $data = array("bookmark_id" => $this->_bookmarkID, "user_id" => $this->_id);
        $action = "addvisit";
        $fields = array(
            "apikey" => APIKEY,
            "apihash" => APIHASH,
            "data" => $data,
            "action" => $action
        );
        $client->setPostFields($fields);
        $returnValue = $client->send();
        $obj = json_decode($returnValue);

        if (!property_exists($obj, "result")) {
            $sess['results'][] = "Error has occured";

        }
        if ($obj->result == 'Success') {
            $sess['results'][] = "Success";
        } else {
            $sess['results'][] = "Could Not Add Visit ";
        }
        return $sess['results'];
    } //end of function
#endregion
} // end of class




/*#region "Search Bookmark"
    function searchBookmark($client, $sess) {
        require_once(__DIR__ . "/../../../tos.php");
        $sess['search'] = array();

        if (count($sess['results']) > 0) {
            $sess['results'][] = "Error Has Occured";
        }

        $data = array("user_id" => $this->_id, "term" => $this->_searchTerm);
        $action = "searchbookmarks";
        $fields = array(
            "apikey" => APIKEY,
            "apihash" => APIHASH,
            "data" => $data,
            "action" => $action,
        );

        $client->setPostFields($fields);
        $returnValue = $client->send();
        $obj = json_decode($returnValue);
        if (!property_exists($obj, "result")) {
            $sess['results'][] = "Error has occured";
        }

        if ($obj->result == "Success" && !empty($obj->data)) {
            $sess['results'][] = "Success";
            $sess['search'][] = $obj->data;
            return $sess['search'];
        } else {
            $sess['results'][] = "No Bookmarks Found";
        }
        return $sess['results'];
    } //end function
#endregion*/
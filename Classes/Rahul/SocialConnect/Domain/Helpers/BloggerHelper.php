<?php
namespace Rahul\SocialConnect\Domain\Helpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Rahul.SocialConnect".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

 use TYPO3\Flow\Annotations as Flow;
 use Rahul\SocialConnect\Exception;
 use Rahul\SocialConnect\Logging\SocialLogger;
 use \TYPO3\TYPO3CR\Exception\NodeException;
 set_include_path(FLOW_PATH_PACKAGES.'Libraries/zend/gdata/library/');
 require_once 'Zend/Loader.php';
 /**
  *	Blogger Helper Class to Post on Blogger
  * @Flow\Scope("prototype")
  */
 class BloggerHelper{
 	
 	/**
 	 * @var array
 	 */
 	protected $settings;

 	/**
 	 * @var string
 	 */
 	protected $blogID;

	/**
	 * @var NodeInterface
	 */
	protected $node;

	/**
	 * @var \Zend_Client
	 */
	protected $gdClient;

	/**
 	 * Inject settings
 	 *
 	 * @param array $settings
 	 * @return void
 	 */
	public function injectSettings(array $settings) {
	    $this->settings = $settings;
	}


	/**
	 * @param NodeInterface $node 
	 * Constructor
	 * @return void
	 */
	public function __construct($node){
		$this->node = $node;
	}

	/**
	 * Helper method to post to Facebook.
	 * Specify username and password along with other data in configuration.yaml files under Configuration
	 * @return void
	 * @api
	 */
	public function post(){
	  try{
	  	  \Zend_Loader::loadClass('Zend_Gdata');
        \Zend_Loader::loadClass('Zend_Gdata_Query'); 
        \Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	  }catch(\Exception $e){
	  	 SocialLogger::bloggerLog($e->getMessage());
	  }

      $this->gdClient = $this->initializeClient($this->settings['blogger']['username'],$this->settings['blogger']['password']);
      $query = new \Zend_Gdata_Query('http://www.blogger.com/feeds/default/blogs');
      $feed = $this->gdClient->getFeed($query);
      try{
      	$this->blogID = $this->getId($feed,$this->settings['blogger']['blogname']);
	  }catch(\Exception $e){
	  	SocialLogger::bloggerLog($e->getMessage());
	  }
    SocialLogger::bloggerLog('herro');
	  $factory = new \Rahul\SocialConnect\Domain\Factory\BloggerFactory($this->node);
	  $ovr = $factory->create();
    $title = $ovr->getHeadline();
    $content = $ovr->getContent();
     if(False){
      	$postId = $this->node->getProperty('blogpost');
      	$this->updatePost($postId,$title,$content);
      	SocialLogger::bloggerLog("Updated Post with id:".$postId);
      }else{
      	$postId = $this->createPost($title,$content);
      	SocialLogger::bloggerLog("Posted with id:".$postId);
      	//$this->node->setProperty('blogpost',$postId);
      }
	}

	/**
	 * A method to add a new post to Blogger
     * @param  string  $title   The title of the blog post.
     * @param  string  $content The body of the post.
     * @param  boolean $isDraft Whether the post should be added as a draft or as a published post
     * @return string The newly created post's ID
     */
    public function createPost($title, $content, $isDraft=False)
    {
        // We're using the magic factory method to create a Zend_Gdata_Entry.
        // http://framework.zend.com/manual/en/zend.gdata.html#zend.gdata.introdduction.magicfactory
        $entry = $this->gdClient->newEntry();
        $entry->title = $this->gdClient->newTitle(trim($title));
        $entry->content = $this->gdClient->newContent($content);
        $entry->content->setType('text');
        $uri = "http://www.blogger.com/feeds/" . $this->blogID . "/posts/default";

        if ($isDraft)
        {
            $control = $this->gdClient->newControl();
            $draft = $this->gdClient->newDraft('yes');
            $control->setDraft($draft);
            $entry->control = $control;
        }

        $createdPost = $this->gdClient->insertEntry($entry, $uri);
        //format of id text: tag:blogger.com,1999:blog-blogID.post-postID
        $idText = explode('-', $createdPost->id->text);
        $postID = $idText[2];
        return $postID;
    }

     /**
     * Retrieves the specified post and updates the title and body. Also sets
     * the post's draft status.
     *
     * @param string  $postID         The ID of the post to update. PostID in <id> field:
     *                                tag:blogger.com,1999:blog-blogID.post-postID
     * @param string  $updatedTitle   The new title of the post.
     * @param string  $updatedContent The new body of the post.
     * @param boolean $isDraft        Whether the post will be published or saved as a draft.
     * @return Zend_Gdata_Entry The updated post.
     */
    public function updatePost($postID, $updatedTitle, $updatedContent, $isDraft=False)
    {
        $query = new Zend_Gdata_Query('http://www.blogger.com/feeds/' . $this->blogID . '/posts/default/' . $postID);
        $postToUpdate = $this->gdClient->getEntry($query);
        SocialLogger::bloggerLog($postToUpdate->title->text);
        $postToUpdate->title->text = $this->gdClient->newTitle(trim($updatedTitle));
        $postToUpdate->content->text = $this->gdClient->newContent(trim($updatedContent));

        if ($isDraft) {
            $draft = $this->gdClient->newDraft('yes');
        } else {
            $draft = $this->gdClient->newDraft('no');
        }

        $control = $this->gdClient->newControl();
        $control->setDraft($draft);
        $postToUpdate->control = $control;
        $updatedPost = $postToUpdate->save();

        return $updatedPost;
    }



	/**
	 * @param string user
	 * @param password
	 * Authenticates the user and returns a client
	 * @return \Zend_GData client
	 */
	private function initializeClient($user,$pass){
	  $client = \Zend_Gdata_ClientLogin::getHttpClient($user,$pass, 'blogger');
      return new \Zend_Gdata($client);
	}

	/**
	 * @param feed $feed
	 * @param string Title
	 * @return id
	 * Returns the Id of the blog taking name of the blog as the input
	 */
	public function getId($feed,$title){
		$id =0;
		foreach ($feed->entries as $entry) {
			if($entry->title->text == $title){
				$idText = explode('-',$entry->id->text);
				$id = $idText[2];
			}

		}
		if($id==null)
			throw new Exception("Invalid Blog name");
		else
			return $id;
	}


 }








?>
<?php 
/* * * * * * * * * * * * * * *
* Returns all published posts
* * * * * * * * * * * * * * */
function getPublishedPosts() {
	// use global $conn object in function
	global $conx;
	$sql = "SELECT * FROM posts WHERE published=true";
	$result =$conx->query($sql);

	// fetch all posts as an associative array called $posts
	$posts = $result->fetchAll();

    $final_posts= array();
    foreach($posts as $post){
        $post['topic']=getPostTopic($post['id']);
        array_push($final_posts,$post);
    }

	return $final_posts;
}

/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns topic of the post
* * * * * * * * * * * * * * */
function getPostTopic($post_id){
	global $conx;
	$sql = "SELECT * FROM topics WHERE id=
			(SELECT topic_id FROM post_topic WHERE post_id=$post_id) LIMIT 1";
	try {$result = $conx->query($sql);} catch(Exception $e) {
		echo "Connection error: " . $e->getMessage();
	}

	$topic = $result->fetch();
	//print_r($topic);
	return $topic;
}

/* * * * * * * * * * * * * * * *
* Returns all posts under a topic
* * * * * * * * * * * * * * * * */
function getPublishedPostsByTopic($topic_id) {
	global $conx;
	$sql = "SELECT * FROM posts ps 
			WHERE ps.id IN 
			(SELECT pt.post_id FROM post_topic pt 
				WHERE pt.topic_id=$topic_id GROUP BY pt.post_id 
				HAVING COUNT(1) = 1)";
	$result = $conx->query($sql);
	// fetch all posts as an associative array called $posts
	$posts = $result->fetchAll();

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}

	return $final_posts;
}

/* * * * * * * * * * * * * * * *
* Returns topic name by topic id
* * * * * * * * * * * * * * * * */
function getTopicNameById($id)
{
	global $conx;
	$sql = "SELECT name FROM topics WHERE id=$id";
	$result = $conx->query($sql);
	$topic = $result->fetch();
	return $topic['name'];
}

/* * * * * * * * * * * * * * *
* Returns a single post
* * * * * * * * * * * * * * */
function getPost($slug){
	global $conx;
	// Get single post slug
	$post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
	$result = $conx->query($sql);
    
	// fetch query results as associative array.
	$posts = $result->fetchAll(PDO::FETCH_ASSOC);
	$post=$posts[0];
	//print_r($post);
	if ($post) {
		// get the topic to which this post belongs
		$post['topic'] = getPostTopic($post['id']);
	}
	return $post;
}
/* * * * * * * * * * * *
*  Returns all topics
* * * * * * * * * * * * */
function getAllTopics()
{
	global $conx;
	$sql = "SELECT * FROM topics";
	$result = $conx->query($sql);
	$topics = $result->fetchAll();
	return $topics;
}

// more functions to come here ...

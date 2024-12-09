<?php
include 'blog-config.php';
if (auth_user()) {
    $memberID = $_SESSION['memberID'];
} else {
	header("Location: blog.php");
    exit();
}

if (!$conn) {
    echo "Failed to connect to MySQL: ".mysqli_connect_error();
}

$pageContent = NULL;
$pageTitle = "Blog";
$title = $content = NULL;
$invalid_title = $invalid_content = NULL;
$msg = NULL;

if(filter_has_var(INPUT_POST, 'edit')) {
	$edit = TRUE;
} else {
	$edit = FALSE;
}

if(filter_has_var(INPUT_POST, 'postID')) {
    $postID = filter_input(INPUT_POST, 'postID');
} elseif(filter_has_var(INPUT_GET, 'postID')) {
    $postID = filter_input(INPUT_GET, 'postID');
} else {
    $postID = NULL;
}

if ($postID) {
    $stmt = $conn->stmt_init();
    if ($stmt->prepare("SELECT `postTitle`, `postContent` FROM `blog` WHERE `postID` = ?")) {
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->bind_result($title, $content);
        $stmt->fetch();
        $stmt->close();
    }
$buttons = <<<HERE
    <div class="form-group">
        <input type="hidden" name="postID" value="$postID">
        <input type="hidden" name="process">
        <input type="submit" name="update" value="Update Post" class="btn btn-success">
    <div>
HERE;
} else {
$buttons = <<< HERE
    <div class="form-group">
        <input type="hidden" name="process">
        <input type="submit" name="insert" value="Save Post" class="btn btn-success">
    </div>
HERE;
}

if(filter_has_var(INPUT_POST, 'delete')) {
    $stmt = $conn->stmt_init();
    if ($stmt->prepare("DELETE FROM `blog` WHERE `postID` = ?")) {
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: blog-admin.php");
    exit();
}

if(filter_has_var(INPUT_POST, 'process')) {
    $valid = TRUE;
    $title = mysqli_real_escape_string($conn, trim(filter_input(INPUT_POST, 'title')));
    if (empty($title)) {
        $invalid_title = '<span class"error">Required field</span>';
        $valid = FALSE;
    }

    $content = mysqli_real_escape_string($conn, trim(filter_input(INPUT_POST, 'content')));
    if (empty($content)) {
        $invalid_content = '<span class"error">Required field</span>';
        $valid = FALSE;
    }

    if($valid) {
        if(filter_has_var(INPUT_POST, 'insert')) {
            $stmt = $conn->stmt_init();
            if ($stmt->prepare("INSERT INTO `blog`(`postTitle`, `postContent`, `authorID`) VALUES (?, ?, ?)")) {
                $stmt->bind_param("ssi", $title, $content, $memberID);
                $stmt->execute();
                $stmt->close();
            }
            $postID = mysqli_insert_id($conn);
            header("Location: blog-admin.php?postID=$postID");
            exit();
        }
        if(filter_has_var(INPUT_POST, 'update')) {
            $stmt = $conn->stmt_init();
            if($stmt->prepare("UPDATE `blog` SET `postTitle`= ?, `postContent`= ? WHERE `postID` = ?")) {
                $stmt->bind_param("ssi", $title, $content, $postID);
                $stmt->execute();
                $stmt->close();
            }
            header("Location: blog-admin.php?postID=$postID");
            exit();
        }
    }
}

if ($edit) {
$pageContent .= <<<HERE
   <section class="container">
    $msg
    <p>Please complete the form below.</p>
    <form action="blog-admin.php" method="post">
        <div class="form-group">
            <label for="title">Blog Title</label>
            <input type="text" name="title" id="title" value="$title" class="form-control"> $invalid_title
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control">$content</textarea> $invalid_content
        </div>
    $buttons
    </form>
    <form action="blog-admin.php" method="post">
        <div class="form-group">
            <input type="submit" name="cancel" value="Show Blog List" class="btn btn-primary">
        </div>
    </form>
   </section>\n
HERE;
} elseif ($postID) {
    $pageContent = <<<HERE
    <h2>Blog Post</h2>
    <h3>$title</h3>
    <p>$content</p>
    <form action="blog-admin.php" method="post">
        <div class="form-group">
            <input type="hidden" name="postID" value="$postID">
            <input type="submit" name="edit" value="Edit Post" class="btn btn-success">
        </div>
    </form>
    <form action="blog-admin.php" method="post">
        <div class="form-group">
            <input type="submit" name="cancel" value="Show Blog List" class="btn btn-primary">
        </div>
    </form>
    <form action="blog-admin.php" method="post">
        <input type="hidden" name="postID" value="$postID">
        <div class="form-group">
            <input type="submit" name="delete" value="Delete Post" class="btn btn-danger">
        </div>
    </form>
HERE;
} else {
    $where = 1;
    $stmt = $conn->stmt_init();
    if ($stmt->prepare("SELECT `postID`, `postTitle` FROM `blog` WHERE `authorID` = ?")) {
        $stmt->bind_param("i", $memberID);
        $stmt->execute();
        $stmt->bind_result($postID, $title);
        $stmt->store_result();
        $classList_row_cnt = $stmt->num_rows();

        if($classList_row_cnt > 0) {
            $selectPost = <<<HERE
            <ul>\n
HERE;
            while($stmt->fetch()) {
                $selectPost .= <<<HERE
                <li><a href="blog-admin.php?postID=$postID">$title</a></li>\n
HERE;
            }
            $selectPost .= <<<HERE
            </ul>\n
HERE;
        } else {
            $selectPost = "<p>There are no blog post avaiable at this time.</p>";
        }
        $stmt->free_result();
        $stmt->close();
    } else {
        $selectPost = "<p>The blog system is down now. Please try again later.</p>";
    }
    $pageContent = <<<HERE
    <h2>Blog List</h2>
    $selectPost
    <form action="blog-admin.php" method="post">
        <div class="form-group">
            <input type="submit" name="edit" value="Create New Post" class="btn btn-success">
        </div>
    </form>
HERE;
}

include 'template.php';

?>
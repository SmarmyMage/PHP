<?php
require_once 'config.php';
require_once 'dashboard-model.php';
require_once 'dashboard-view.php';

if (auth_user()) {
   // $memberID = $_SESSION['memberID'];
} else {
	header("Location: login.php?msg=Users must be logged in to access this page.");
    exit();
}

$firstname = $lastname = NULL;
$pageContent = $msg = NULL;

if(filter_has_var(INPUT_POST, 'edit')) {
	$edit = TRUE;
} else {
	$edit = FALSE;
}

if(filter_has_var(INPUT_POST, 'memberID')) {
    $memberID = filter_input(INPUT_POST, 'memberID');
} elseif(filter_has_var(INPUT_GET, 'memberID')) {
    $memberID = filter_input(INPUT_GET, 'memberID');
} else {
    $memberID = NULL;
}

if(filter_has_var(INPUT_GET, 'msg')) {
    $msg = filter_input(INPUT_GET, 'msg');
    $msg = "<p class='alert alert-success'>$msg</p>";
} else {
    $msg = NULL;
}

if(filter_has_var(INPUT_POST, 'delete')) {
    if (deleteMember($conn, $memberID)) {
        $msg = "Member Deleted.";
    } else {
        $msg = "Member Not Deleted.";
    }
    header("Location: dashboard.php?msg=$msg");
    exit();
}

if (filter_has_var(INPUT_POST, 'save')) {
    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname = filter_input(INPUT_POST, 'lastname');
    if (filter_has_var(INPUT_POST, 'block') == 1) {
        $block = 1;
    } else {
        $block = 0;
    }
    if (!empty($memberID)) {
        if(updateMember($conn, $firstname, $lastname, $block, $memberID)) {
            $msg = "Member Updated.";
        } else {
            $msg = "Member Not Updated";
        }
    }
    header("Location: dashboard.php?memberID=$memberID&msg=$msg");
    exit();
}

if(!empty($memberID)) {
    $memberData = memberInfo($conn, $memberID);
    $firstname = $memberData[0];
    $lastname = $memberData[1];
} else {
    $memberList = NULL;
    $memberListData = membersInfo($conn);
    foreach($memberListData as $memberInfo) {
        foreach ($memberInfo as $memberIDList => $firstname) {
            if($memberIDList == 0) {
                $memberList = <<<HERE
            <p>$memberIDList is $firstname</p>
HERE;
            } else {
                $memberList .= <<<HERE
                <p><a href="profile.php?memberID=$memberIDList">$firstname</a></p>
HERE;
            }
        }
    }
}

if(filter_has_var(INPUT_POST, 'edit')) {
    $pageContent = memberEditView($memberID, $firstname, $lastname);
} elseif (!empty($memberID)) {
    $pageContent = memberView($memberID, $firstname, $lastname);
} else {
    $pageContent = memberListView($memberList);
}

$pageTitle = "My Blog";
include 'template.php';
?>
<?php
function deleteMember($conn, $memberID) {
    $stmt = $conn->stmt_init();
    if($stmt->prepare("DELETE FROM `membership` WHERE `memberID` = ?")) {
        $stmt->bingparam("i", $memberID);
        $stmt->execute();
        $stmt->close();
        return TRUE;
    } else {
        return FALSE;
    }
}

function updateMember($conn, $firstname, $lastname, $block, $memberID) {
    $stmt = $conn->stmt_init();
    if($stmt->prepare("UPDATE `membership` SET `firstname`= ?, `lastname`= ?, `block`= ? WHERE `memberID` = ?")) {
        $stmt->bind_param("ssii", $firstname, $lastname, $block, $memberID);
        $stmt->execute();
        $stmt->close();
        return TRUE;
    } else {
        return FALSE;
    }
}

function memberInfo($conn, $memberID) {
    $stmt = $conn->stmt_init();
    if($stmt->prepare("SELECT firstname, lastname FROM membership WHERE memberID= ?")) {
        $stmt->bind_param("i", $memberID);
        $stmt->execute();
        $stmt->bind_result($firstname, $lastname);
        $stmt->fetch();
        $stmt->close();
    }
    $memberData = array($firstname, $lastname);
    return $memberData;
}

function membersInfo($conn) {
    $stmt = $conn->stmt_init();
    if($stmt->prepare("SELECT `memberID`, `firstname` FROM `membership`")) {
        $stmt->execute();
        $stmt->bind_result($memberID, $firstname);
        $stmt->store_result();
        $postList_row_cnt = $stmt->num_rows();
        if($postList_row_cnt > 0) {
            while($stmt->fetch()) {
                $memberData = [$memberID => $firstname];
                $memberListData[] = $memberData;
            }
        } else {
            $memberData = ["There are no members at this time."];
            $memberListData[] = $memberData;
        }
        $stmt->free_result();
        $stmt->close();
    } else {
        $memberData = ["Please try again later."];
        $memberListData[] = $memberData;
    }
    return $memberListData;
}
?>
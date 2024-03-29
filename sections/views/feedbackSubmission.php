<?php

require '../../config.php';
require '../../functions.php';
// Function to submit feedback
function submitFeedback($couponId, $feedback, $user_id) {

    // Assuming you have a user_id for the current user, replace 'replace_with_actual_user_id' with the actual user_id
    $userId = $user_id;
	$statement = connect()->prepare("SELECT * FROM user_preferences WHERE user_id = :user_id AND coupon_id = :coupon_id LIMIT 1");
	$statement->execute(array(':user_id' => $userId, ':coupon_id'=>$couponId));
	$result = $statement->fetch();

	if ($result != false) {
		
		return ['already_submitted' => true]; 
	
	}

    // Insert feedback into user_feedback table
	$statement = connect()->prepare("INSERT INTO user_preferences (id, user_id, coupon_id, preference, created_at) VALUES (null, :user_id, :coupon_id, :preference, CURRENT_TIMESTAMP)");

	$statement->execute(array(
		':user_id' => $userId,
		':coupon_id' => $couponId,
		':preference' => $feedback,
	));

    // Check the number of affected rows
    $rowCount = $statement->rowCount();

    if ($rowCount > 0) {
        // Feedback inserted successfully
        // Update total_like or total_dislike in the coupon table
        updateCouponFeedbackCount($couponId, $feedback);
        return ['success' => true];
    } else {
        // Feedback insertion failed
        return ['success' => false];
    }
}

function updateCouponFeedbackCount($couponId, $feedback) {
    $columnName = ($feedback == 'like') ? 'total_like' : 'total_dislike';
    
    // Update the respective column in the coupon table
    $updateStatement = connect()->prepare("UPDATE coupons SET $columnName = $columnName + 1 WHERE coupon_id = :coupon_id");
    $updateStatement->execute(array(':coupon_id' => $couponId));

    // Check for errors in the SQL execution
    $errorInfo = $updateStatement->errorInfo();

    if ($errorInfo[0] !== '00000') {
        // There was an error in the SQL execution
        return ['error' => 'Failed to update coupon feedback count. Error: ' . implode(', ', $errorInfo)];
    }

    return true; // Success
}

// Check if the request is an AJAX request and has the necessary parameters
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coupon_id']) && isset($_POST['feedback']) && isset($_POST['user_id'])) {
    $couponId = $_POST['coupon_id'];
    $feedback = $_POST['feedback'];
    $user_id = $_POST['user_id'];

    if($_POST['user_id']== "") {
        echo "3";
        exit();
    }

    // Submit feedback and send JSON response
    $response = submitFeedback($couponId, $feedback, $user_id);
    if(isset($response['already_submitted']) && $response['already_submitted'] == true) {
        echo "0";
    }

    if(isset($response['success']) && $response['success'] == true) {
        echo "1";
    }

    if(isset($response['success']) && $response['success'] == false) {
        echo "2";
    }
    exit();
}
?>
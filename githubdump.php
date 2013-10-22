<?php

// Set the payload.
$githubdump_payload = $_POST['payload'];

// Define the branch to check for commit.
// If you want to monitor all commits, set value to 'allcommits'.
$githubdump_branch = 'allcommits';

// Check the branch commit belongs to.
$githubdump_check_branch = githubdump_compare_branch($githubdump_payload, $githubdump_branch);

/**
 * Do your stuff here.
 *  @param: object of json provided in payload by Github.
 */
function githubdump($payload_object) {
    // Write your code here.
}

/**
 * Compare the branch.
 */
function githubdump_compare_branch($githubdump_payload, $githubdump_required_branch) {
	$githubdump_get_branch = githubdump_get_branch($githubdump_payload, $githubdump_required_branch);
	$githubdump_received_branch = $githubdump_get_branch['branch'];
	$githubdump_payload = $githubdump_get_branch['object'];

	if ($githubdump_received_branch == $githubdump_required_branch && $githubdump_required_branch !== 'allcommits') {
		githubdump($githubdump_payload);
		return TRUE;
	}
	return FALSE;
}

/**
 * Get the branch.
 */
function githubdump_get_branch($githubdump_payload, $githubdump_required_branch) {
	if (isset($githubdump_payload) && !empty($githubdump_payload)) {
		// Convert json into object.
		$githubdump_received_object = json_decode($githubdump_payload);
		// Get the branch.
		$githubdump_received_branch = str_replace('refs/heads/', '', $githubdump_received_object->ref);
		print_r($githubdump_received_object);
		print_r($githubdump_received_branch);
		return array(
			     'object' => $githubdump_received_object,
			     'branch' => $githubdump_received_branch,
			     );
	}
	return FALSE;
}
<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 16-May-19
 * Time: 12:46 PM
 */

// TODO: database cron job

// notification request
// 1 show to that user
// -1 that user has viewed
// request
// 1 user requested
// 2 admin reacted
// -1 user requested viewed

//batch attendace report past in intern

require_once  $asset_path_link."includes/layouts/_connect.php";

const present = 1;  // normal present
const absent = -1;  // normal absent
const role_id_intern = 4;  // role  id of intern

//-----------------------------------------PREPARED STATEMENT FOR MYSQLi SYNTAX positional placeholders ------------------------------------
function modifyRecord($sql, $types, $params) {
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
function getMultipleRecords($sql, $types = null, $params = []) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if (!empty($params) && !empty($params)) { // parameters must exist before you call bind_param() method
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $arr = $result->fetch_all(MYSQLI_ASSOC);
    if(!$arr) return('No Rows');
    $stmt->close();
    return $arr;
}
function getSingleRecord($sql, $types, $params) {
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $arr = $result->fetch_assoc();
    if(!$arr) return('No Row');
    $stmt->close();
    return $arr;
}
//------------------------- PREPARED STATEMENT FOR PDO SYNTAX positional placeholders-------------------------------
function getSingleRecordPDO($sql, $params) {
   global $pdo_conn;
   $conn= $pdo_conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $arr = $stmt->fetch();
//        if(!$arr) exit('NO Row');
    return $arr;
}
function getMultipleRecordsPDO($sql, $types = null, $params = []) {
   global $pdo_conn; $conn= $pdo_conn;
    $stmt = $conn->prepare($sql);
    if (!empty($params) && !empty($params)) { // parameters must exist before you call bind_param() method
        $stmt->execute($params);
    }
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

//        if(!$arr) exit('NO Rows');
    return $arr;
}
function getMultipleRecordsPDONoPara($sql,$fetch_type) {
   global $pdo_conn; $conn= $pdo_conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $arr = $stmt->fetchAll($fetch_type);
//        if(!$arr) exit('NO Rows!');
    return $arr;
}
function modifyRecordPDO($sql, $params) {
   global $pdo_conn; $conn= $pdo_conn;
    $result = $conn->prepare($sql)->execute($params);
    return $result;

}

//--------------------------------

function test_check()
{
    $str = "Hey, you called test_check() function. Anything else.";
    echo $str;
    return $str;
}

function test_check1($param, $p2)
{
    $str = "Hey, you called test_check() function with param1 - ".$param." param2 -".$p2;
    echo $str;
    return $str;
}

/** // user check in db exist or not - sign in page
 * @param $uname
 * @return mixed
 */
function login_username($uname){
    $sql = "SELECT * FROM users WHERE (BINARY username=? OR email=? ) AND c_status=1 LIMIT 1";
    $user = getSingleRecordPDO($sql, [$uname,$uname]);
    return $user;
}

/** // get userid from unique username
 * @param $uname
 * @return mixed
 */
function getUserUid($uname){
    $sql = "SELECT id FROM users WHERE (username=? OR email=? ) AND c_status=1 LIMIT 1";
    $user = getSingleRecordPDO($sql, [$uname,$uname]);
    return $user;
}

/** // updating user password
 * @param $newPass
 * @param $userId
 * @return bool
 */
function updateUserPassword($newPass, $userId){
    $sql = "UPDATE users SET password=?, updated_at=current_timestamp WHERE id=?";
    $result =  modifyRecordPDO($sql,[$newPass,$userId]);
    return $result;
}

/**  // checking if user exist with this email or username
 * @param $email
 * @param $username
 * @return mixed
 */
function checkUserNameEmail($email, $username){
    $sql = "SELECT email,username FROM users WHERE  email=? OR username=? LIMIT 1  ";
    $user =  getSingleRecordPDO($sql, [$email,$username]);
    return $user;
}


/**
 * @return array
 */
function getAllRoles(){
    $sql = "SELECT * FROM roles WHERE status=1";
    $roles = getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC );
    return $roles;
}

/** // get role of particular user from his user id.
 * @param $userId
 * @return mixed
 */
function getRoleOfUser($userId){
    $sql = "SELECT 
                   u.id, u.role_id, u.username, u.email, r.name as role, r.description, r.folder_name
                FROM users u 
                LEFT JOIN roles r ON u.role_id=r.id 
                WHERE u.id=? 
                LIMIT 1";
    $user =  getSingleRecordPDO($sql, [$userId]);
    return $user;
}

//function getUserAllDetails($userId){
//    $sql = "SELECT * FROM users WHERE id=? LIMIT 1";
//    $oldUser =  getSingleRecordPDO($sql, [$userId]);
//    return $oldUser;
//}

/** // get user details from his role and profile
 * @param $userId
 * @return mixed
 */
function getUserRoleProfile($userId)
{
    $sql = "SELECT 
		u.id as uid, u.role_id as role_id, u.username, u.email, u.password, u.c_status, u.created_at, u.updated_at, p.user_sign,
        r.name as role, r.description as r_description, r.folder_name as user_folder, 
        p.id as pid, p.full_name, p.profile_picture 
            FROM users u, roles r, profiles p 
            WHERE u.id=? AND u.role_id=r.id AND p.user_id=u.id
            LIMIT 1
            ";
    $user =  getSingleRecordPDO($sql, [$userId]);
    return $user;
}

/** // get all user details from his role and profile - userlist page
 * @return array
 */
function getUserRoleProfileOfAll()
{
    $users = array();
    $sql = "SELECT 
		u.id as uid, u.role_id as role_id, u.username, u.email, u.c_status, u.created_at, u.updated_at, 
        r.name as role, r.description as r_description, r.folder_name as user_folder, r.dt_row_color_class,
        p.id as pid, p.full_name, p.profile_picture 
            FROM users u, roles r, profiles p 
            WHERE u.role_id=r.id AND p.user_id=u.id
            ";
    $users =  getMultipleRecordsPDONoPara($sql, PDO::FETCH_ASSOC);
    return $users;
}

/**  // insert new user in db
 * @param $roleId
 * @param $username
 * @param $email
 * @param $password
 * @return bool
 */
function insertUser($roleId, $username, $email, $password){
    global $pdo_conn;
    $sql = "INSERT INTO users (role_id, username, email,password) VALUES (?,?,?,?)";
    $user =  modifyRecordPDO($sql, [$roleId, $username,$email,$password]);
//    $inserted_id = $pdo_conn->lastInsertId();
    return $user;
}

/**
 * @param $user_id
 * @param $full_name
 * @return bool
 */
function insertProfileName($user_id, $full_name){
    $sql = "INSERT INTO profiles (user_id,full_name) VALUES (?,?)";
    $user =  modifyRecordPDO($sql, [$user_id, $full_name]);
    return $user;
}

/**
 * @param $user_id
 * @param $profile_pic_name
 * @return bool
 */
function insertProfilePictureName($user_id, $profile_pic_name){
    $sql = "UPDATE profiles SET profile_picture=? WHERE user_id=?";
    $user =  modifyRecordPDO($sql, [$profile_pic_name,$user_id]);
    return $user;
}

function insertUserSignName($user_id, $user_sign_name){
    $sql = "UPDATE profiles SET user_sign=? WHERE user_id=?";
    $user =  modifyRecordPDO($sql, [$user_sign_name,$user_id]);
    return $user;
}

/**
 * @param $used_id_to_disable
 * @param $actionTaken
 * @param $byUserId
 * @return bool
 */
function disableUserSignIn($used_id_to_disable, $actionTaken, $byUserId){
    $sql = "UPDATE users SET c_status=?,action_by_id=? WHERE id=?";
    $result =  modifyRecordPDO($sql,[$actionTaken,$byUserId,$used_id_to_disable]);
    return $result;
}

function resetUserSignIn($used_id_to_reset, $actionTaken, $byUserId){
    $sql = "UPDATE users SET password=?,action_by_id=? WHERE id=?";
    $result =  modifyRecordPDO($sql,[$actionTaken,$byUserId,$used_id_to_reset]);
    return $result;
}
//-------------------------------------------- BATCH INTERNS -------------------------------------------------

/**
 * @param $today_date_normal
 * @return mixed
 */
function getAllOngoingBatchesCount($today_date_normal){
    $sql = "SELECT COUNT(id) as ongoing_batch_count
            FROM batches
            WHERE (? BETWEEN from_d_b AND to_d_b)";
    $batches = getSingleRecordPDO($sql,[$today_date_normal]);
    return $batches;
}

/**
 * @param $today_date_normal
 * @return mixed
 */
function getAllOngoingBatchesInternsCount($today_date_normal){
    $sql = "SELECT COUNT(bi.id) as ongoing_inter_count
            FROM batches b, batch_interns bi
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND bi.batch_id=b.id and bi.moved is null";
    $batches = getSingleRecordPDO($sql,[$today_date_normal]);
    return $batches;
}

function getAllOngoingBatchesInternsList($today_date_normal){
    $role_id_intern = role_id_intern;
    $sql = "SELECT 
		u.id as uid, u.role_id as role_id, u.username, u.email, u.c_status, u.created_at, u.updated_at, 
        p.id as pid, p.full_name, p.profile_picture, bi.batch_id, b.batch_name, b.batch_year, b.from_d_b, b.to_d_b
            FROM users u,profiles p, batches b, batch_interns bi
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND u.role_id='$role_id_intern' AND u.c_status=1 AND p.user_id=u.id  AND bi.intern_id =u.id AND bi.batch_id=b.id and bi.moved is null
            order by p.full_name, u.created_at
    ";
    $batches = getMultipleRecordsPDO($sql,'s',[$today_date_normal]);
    return $batches;
}

/** // insert new batch into db
 * @param $batch_name
 * @param $batch_year
 * @param $batch_start_date_string_time
 * @param $batch_end_date_string_time
 * @param $userId
 * @return bool
 */
function insertBatches($batch_name, $batch_year, $batch_start_date_string_time, $batch_end_date_string_time, $userId){
    $sql = "INSERT INTO batches (batch_name, batch_year, from_d_b, to_d_b, created_by_id) VALUES (?,?,?,?,?)";
    $result =  modifyRecordPDO($sql, [$batch_name,$batch_year,$batch_start_date_string_time,$batch_end_date_string_time,$userId]);
    return $result;
}

function checkBatchName($b_name){
    $sql = "SELECT batch_name FROM batches WHERE  batch_name=? LIMIT 1  ";
    $batch =  getSingleRecordPDO($sql, [$b_name]);
    return $batch;
}

/** // changing interns from one batch to other
 * @param $batch_id
 * @param $selected_interns_id_str
 * @return bool
 */
function updateChangeBatch($batch_id, $selected_interns_id_str){
    $sql = "UPDATE batch_interns SET moved=? WHERE batch_id=? AND intern_id=? AND moved IS NULL";
    $result =  modifyRecordPDO($sql,[1,$batch_id,$selected_interns_id_str]);
    return $result;
}

/** // insert new interns into batch
 * @param $batch_id
 * @param $selected_interns_id_str
 * @param $userId
 * @return bool
 */
function insertBatchInterns($batch_id, $selected_interns_id_str, $userId){
    $sql = "INSERT INTO batch_interns (batch_id, intern_id, added_by) VALUES (?,?,?)";
    $result =  modifyRecordPDO($sql, [$batch_id,$selected_interns_id_str,$userId]);
    return $result;
}

/** // get all the ongoing batch interns
 * @param $today_date_normal
 * @return array
 */
function getAllOngoingBatches($today_date_normal){
    $sql = "SELECT id as bid, batch_name, batch_year, from_d_b, to_d_b, created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=batches.created_by_id) as created_by_name, created_by_id, 
            (SELECT COUNT(*) FROM batch_interns bi WHERE bi.batch_id=batches.id AND bi.moved IS NULL) as number_of_interns
            FROM batches
            WHERE (? BETWEEN from_d_b AND to_d_b)
            ORDER BY batch_name,created_at ";
    $batches = getMultipleRecordsPDO($sql,'s',[$today_date_normal]);
    return $batches;
}

function getAllOngoingBatchesOfUser($today_date_normal, $userId){
    $sql = "SELECT b.id as bid, b.batch_name, b.batch_year, b.from_d_b, b.to_d_b, b.created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=b.created_by_id) as created_by_name, b.created_by_id, 
            (SELECT COUNT(*) FROM batch_interns bi WHERE bi.batch_id=b.id AND bi.moved IS NULL) as number_of_interns
            FROM batches b, batch_interns bi
            WHERE (? BETWEEN from_d_b AND to_d_b) and bi.batch_id=b.id and bi.intern_id=? and bi.moved IS NULL
            ORDER BY b.batch_name,b.created_at ";
    $batches = getMultipleRecordsPDO($sql,'si',[$today_date_normal,$userId]);
    return $batches;
}

function getBatch($batch_id){
    $sql = "SELECT id as bid, batch_name, batch_year, from_d_b, to_d_b, created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=batches.created_by_id) as created_by_name, created_by_id, 
            (SELECT COUNT(*) FROM batch_interns bi WHERE bi.batch_id=batches.id AND bi.moved IS NULL) as number_of_interns
            FROM batches
            WHERE id=? ";
    $batches = getSingleRecordPDO($sql,[$batch_id]);
    return $batches;
}

function getUserRoleProfileOfInternsInBatch($batch_id)
{
    $users = array();
    $sql = "SELECT 
		u.id as uid, u.role_id as role_id, u.username, u.email, u.c_status, u.created_at, u.updated_at, 
        r.name as role, r.description as r_description, r.folder_name as user_folder, r.dt_row_color_class,
        p.id as pid, p.full_name, p.profile_picture 
            FROM users u, roles r, profiles p, batch_interns bi
            WHERE bi.batch_id=? AND bi.moved IS NULL AND bi.intern_id=u.id AND u.role_id=r.id AND p.user_id=u.id
ORDER BY p.full_name, u.created_at
            ";
    $users =  getMultipleRecordsPDO($sql,'i' ,[$batch_id]);
    return $users;
}

function getUserRoleProfileOfInternsInALLBatch()
{
    $users = array();
    $sql = "SELECT 
		u.id as uid, u.role_id as role_id, u.username, u.email, u.c_status, u.created_at, u.updated_at, 
        r.name as role, r.description as r_description, r.folder_name as user_folder, r.dt_row_color_class,
        p.id as pid, p.full_name, p.profile_picture 
            FROM users u, roles r, profiles p, batch_interns bi
            WHERE  bi.moved IS NULL AND bi.intern_id=u.id AND u.role_id=r.id AND p.user_id=u.id
            ";
    $users =  getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC);
    return $users;
}


function getAllHistoryBatches(){
    $sql = "SELECT id as bid, batch_name, batch_year, from_d_b, to_d_b, created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=batches.created_by_id) as created_by_name, created_by_id, 
            (SELECT COUNT(*) FROM batch_interns bi WHERE bi.batch_id=batches.id AND bi.moved IS NULL) as number_of_interns
            FROM batches
             ORDER BY batch_name,created_at ";
    $batches = getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC);
    return $batches;
}

function getAllHistoryBatchesOfUser($userId){
    $sql = "SELECT b.id as bid, b.batch_name, b.batch_year, b.from_d_b, b.to_d_b, b.created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=b.created_by_id) as created_by_name, b.created_by_id, 
            (SELECT COUNT(*) FROM batch_interns bi WHERE bi.batch_id=b.id AND bi.moved IS NULL) as number_of_interns
            FROM batches b, batch_interns bi
where b.id=bi.batch_id and bi.intern_id=?
             ORDER BY batch_name,created_at ";
    $batches = getMultipleRecordsPDO($sql,'i',[$userId]);
    return $batches;
}

/** get particular user batch interns
 * @param $user_id
 * @return array
 */
function getAllOngoingBatchesOfPartUser($user_id){
    $sql = "SELECT b.id as bid, b.batch_name, b.batch_year, b.from_d_b, b.to_d_b, b.created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=b.created_by_id) as created_by_name, b.created_by_id
            FROM batches b, batch_interns bi
            WHERE b.id=bi.batch_id AND bi.intern_id=? and bi.moved IS NULL";
    $batches = getMultipleRecordsPDO($sql,'s',[ $user_id]);
    return $batches;
}

/**     // add new interns into batches
 * @param $today_date_normal
 * @param $batch_id_from
 * @return array
 */
function getAllOngoingBatchesExcept($today_date_normal, $batch_id_from){
    $sql = "SELECT id as bid, batch_name, batch_year, from_d_b, to_d_b, created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=batches.created_by_id) as created_by_name, created_by_id, 
            (SELECT EXTRACT(MONTH FROM batches.created_at) )as created_at_month
            FROM batches
            WHERE (? BETWEEN from_d_b AND to_d_b ) AND id NOT IN (?)";
    $batches = getMultipleRecordsPDO($sql,'i',[$today_date_normal,$batch_id_from]);
    return $batches;
}

function getAllInternsToAdd(){
    $intern_role_id = role_id_intern;
    $sql = "SELECT u.id as uid, u.role_id as role_id, u.username, u.email, u.password, u.c_status, u.created_at, u.updated_at, 
                    r.name as role, r.description as r_description, r.folder_name as user_folder,
                    p.id as pid, p.full_name, p.profile_picture 
            FROM users u, profiles p, roles r
            WHERE u.role_id='$intern_role_id' AND u.c_status=1 AND u.role_id=r.id AND p.user_id=u.id
                  AND u.id NOT IN (SELECT DISTINCT bi.intern_id FROM batch_interns bi WHERE moved IS NULL)
                  ORDER BY p.full_name, u.created_at;
                  ";
    $interns = getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC );
    return $interns;
}

//----------------------------------------------TEAM AND PROJECT -------------------------------------------

function getAllOngoingProjectsCount($project_status){
    $sql = "SELECT COUNT(p.id) as ongoing_project_count
            FROM projects p, team_projects tp
            WHERE p.status=? AND p.id=tp.project_id";
    $batches = getSingleRecordPDO($sql,[$project_status]);
    return $batches;
}

function getAllOngoingProjectsCountOfUser($project_status,$userId){
    $sql = "SELECT COUNT(p.id) as ongoing_project_count
            FROM projects p, team_projects tp, team_interns ti
            WHERE p.status=? AND p.id=tp.project_id AND tp.team_id=ti.team_id AND ti.intern_id=? ";
    $batches = getSingleRecordPDO($sql,[$project_status,$userId]);
    return $batches;
}

function getAllOngoingTEAMSCount($today_date_normal){
    $sql = "SELECT COUNT(t.id) as ongoing_team_count
            FROM teams t, batches b
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND t.batch_id=b.id";
    $batches = getSingleRecordPDO($sql,[$today_date_normal]);
    return $batches;
}

function getAllOngoingTEAMSCountOfUser($today_date_normal, $userId){
    $sql = "SELECT COUNT(t.id) as ongoing_team_count
            FROM teams t, batches b, team_interns ti
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND t.batch_id=b.id and ti.team_id=t.id and ti.intern_id=? and ti.moved is null";
    $batches = getSingleRecordPDO($sql,[$today_date_normal, $userId]);
    return $batches;
}

function checkTeamName($t_name){
    $sql = "SELECT team_name FROM teams WHERE  team_name=? LIMIT 1  ";
    $batch =  getSingleRecordPDO($sql, [$t_name]);
    return $batch;
}

function checkProjectName($p_name){
    $sql = "SELECT project_name FROM projects WHERE  project_name=? LIMIT 1  ";
    $batch =  getSingleRecordPDO($sql, [$p_name]);
    return $batch;
}

/** // ongoing batch's team project - all the project of ongoing batch and teams
 * @param $today_date_normal
 * @return array
 */
function getAllOnGoingBatchTeamsProject($today_date_normal){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=b.created_by_id) as created_by_name,  b.created_by_id, t.team_name,  t.id as tid, t.created_at as team_timestamp, (SELECT p.project_name FROM projects p WHERE p.id=tp.project_id) as project_name,
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members
            FROM batches b, teams t, team_projects tp
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND  t.batch_id=b.id AND tp.team_id = t.id
            ORDER BY t.created_at";
    $projects = getMultipleRecordsPDO($sql,'s',[$today_date_normal]);
    return $projects;
}

function getProject($project_id){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, 
       t.team_name,  t.id as tid, t.created_at as team_timestamp, 
       p.project_name, p.created_at as project_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=p.created_by_id) as created_by_name_project, p.id as pid, p.status as pj_status,
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members
            FROM batches b, teams t, team_projects tp, projects p
            WHERE p.id=? AND t.batch_id=b.id AND tp.team_id = t.id AND tp.project_id=p.id
            ORDER BY p.project_name";
    $project = getSingleRecordPDO($sql,[$project_id]);
    return $project;
}

function getAllHistoryProject(){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, t.team_name,  t.id as tid, t.created_at as team_timestamp, p.project_name, p.created_at as project_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=p.created_by_id) as created_by_name_project, p.id as pid,
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members
            FROM batches b, teams t, team_projects tp, projects p
            WHERE  t.batch_id=b.id AND tp.team_id = t.id AND tp.project_id=p.id
            ORDER BY p.project_name, p.created_at";
    $projects = getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC);
    return $projects;
}

function getAllHistoryProjectOfUser($userId){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, t.team_name,  t.id as tid, t.created_at as team_timestamp, p.project_name, p.created_at as project_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=p.created_by_id) as created_by_name_project, p.id as pid,
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members
            FROM batches b, teams t, team_projects tp, projects p, team_interns ti
            WHERE  t.batch_id=b.id AND tp.team_id = t.id AND tp.project_id=p.id and ti.team_id=t.id and ti.intern_id=?
            ORDER BY p.project_name, p.created_at";
    $projects = getMultipleRecordsPDO($sql,'i',[$userId]);
    return $projects;
}

function getAllOnGoingProject($status){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, t.team_name,  t.id as tid, t.created_at as team_timestamp, p.project_name, p.created_at as project_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=p.created_by_id) as created_by_name_project, p.id as pid,
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members
            FROM batches b, teams t, team_projects tp, projects p
            WHERE p.status=? AND t.batch_id=b.id AND tp.team_id = t.id AND tp.project_id=p.id
            ORDER BY p.project_name, t.team_name ";
    $projects = getMultipleRecordsPDO($sql,'i',[$status]);
    return $projects;
}

function getAllOnGoingProjectOfUser($status, $userId){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, t.team_name,  t.id as tid, t.created_at as team_timestamp, p.project_name, p.created_at as project_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=p.created_by_id) as created_by_name_project, p.id as pid,
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members
            FROM batches b, teams t, team_projects tp, projects p, team_interns ti
            WHERE p.status=? AND t.batch_id=b.id AND tp.team_id = t.id AND tp.project_id=p.id and ti.team_id=t.id and ti.intern_id=?
            ORDER BY p.project_name, t.team_name ";
    $projects = getMultipleRecordsPDO($sql,'i',[$status,$userId]);
    return $projects;
}

function getUserRoleProfileOfInternsInProject($team_id)
{
    $users = array();
    $sql = "SELECT 
		u.id as uid, u.role_id as role_id, u.username, u.email, u.c_status, u.created_at, u.updated_at, 
        r.name as role, r.description as r_description, r.folder_name as user_folder, r.dt_row_color_class,
        p.id as pid, p.full_name, p.profile_picture 
            FROM users u, roles r, profiles p, team_interns ti
            WHERE ti.team_id=? AND ti.moved IS NULL AND ti.intern_id=u.id AND u.role_id=r.id AND p.user_id=u.id
            ";
    $users =  getMultipleRecordsPDO($sql,'i' ,[$team_id]);
    return $users;
}

function getAllProjects(){
    $sql = "SELECT  * 
            FROM projects p
            WHERE p.status=1
            ORDER BY p.project_name";
    $projects = getMultipleRecordsPDONoPara($sql, PDO::FETCH_ASSOC);
    return $projects;
}

/**
 * @param $project_name
 * @param $userId
 * @return string
 */
function insertProject($project_name, $userId){
    global $pdo_conn;
    $sql = "INSERT INTO projects (project_name, created_by_id) VALUES (?,?)";
    $project =  modifyRecordPDO($sql, [$project_name,$userId]);
    return $pdo_conn->lastInsertId();
}
function updateProjectStatus($status, $p_id ){
    $sql = "UPDATE projects p SET p.status=? WHERE p.id=?";
    $result =  modifyRecordPDO($sql,[$status, $p_id ]);
    return $result;
}
/** // all the project of ongoing batch and teams of particular user involved in
 * @param $today_date_normal
 * @param $user_id
 * @return array
 */
function getParticularUserOnGoingBatchTeamsProject($today_date_normal, $user_id){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=b.created_by_id) as created_by_name,  b.created_by_id, t.team_name,  t.id as tid, t.created_at as team_timestamp, (SELECT p.project_name FROM projects p WHERE p.id=tp.project_id) as project_name,
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members
            FROM batches b, teams t, team_projects tp, team_interns ti
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND  t.batch_id=b.id AND tp.team_id = t.id AND ti.intern_id=? and ti.team_id=t.id
            ORDER BY t.created_at";
    $projects = getMultipleRecordsPDO($sql,'i',[$today_date_normal, $user_id]);
    return $projects;
}

/**
 * @param $team_name
 * @param $batch_id
 * @param $userId
 * @return string
 */
function insertTeam($team_name, $batch_id, $userId){
    global $pdo_conn;
    $sql = "INSERT INTO teams (team_name,batch_id,created_by_id) VALUES (?,?,?)";
    $team =  modifyRecordPDO($sql, [$team_name,$batch_id,$userId]);
    return $pdo_conn->lastInsertId();
}

/** assign the project to team
 * @param $project_id
 * @param $team_id
 * @return bool
 */
function insertTeamProject($project_id, $team_id){
    $sql = "INSERT INTO team_projects (project_id, team_id) VALUES (?,?)";
    $result =  modifyRecordPDO($sql, [$project_id,$team_id]);
    return $result;
}

/**     insert the batch interns into teams
 * @param $team_id
 * @param $selected_interns_id_str
 * @param $userId
 * @return bool
 */
function insertTeamInterns($team_id, $selected_interns_id_str, $userId){
    $sql = "INSERT INTO team_interns (team_id, intern_id, created_by_id) VALUES (?,?,?)";
    $result =  modifyRecordPDO($sql, [$team_id,$selected_interns_id_str,$userId]);
    return $result;
}

function getTeam($team_id){
    $sql = "SELECT  
b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, 
t.id as tid, t.team_name, t.created_at as team_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=t.created_by_id) as created_by_name_team, 
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members,
(SELECT COUNT(*) FROM team_projects tp WHERE tp.team_id=t.id AND tp.moved IS NULL) as num_projects
            FROM batches b, teams t, team_interns ti
            WHERE t.id=? AND t.batch_id=b.id AND ti.team_id = t.id
            ORDER BY t.team_name";
    $project = getSingleRecordPDO($sql,[$team_id]);
    return $project;
}

function getAllOnGoingProjectOfTeam($team_id){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, t.team_name,  t.id as tid, t.created_at as team_timestamp, p.project_name, p.created_at as project_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=p.created_by_id) as created_by_name_project, p.id as pid,
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members, p.status as project_status
            FROM batches b, teams t, team_projects tp, projects p
            WHERE tp.team_id=? AND t.batch_id=b.id AND tp.team_id = t.id AND tp.project_id=p.id
            ORDER BY p.project_name, p.created_at";
    $projects = getMultipleRecordsPDO($sql,'i',[$team_id]);
    return $projects;
}

function getAllHistoryTeams(){
    $sql = "SELECT  
b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, 
t.id as tid, t.team_name, t.created_at as team_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=t.created_by_id) as created_by_name_team, 
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members,
(SELECT COUNT(*) FROM team_projects tp WHERE tp.team_id=t.id AND tp.moved IS NULL) as num_projects
            FROM batches b, teams t
            WHERE t.batch_id=b.id 
            ORDER BY t.team_name, t.created_at";
    $projects = getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC);
    return $projects;
}

function getAllHistoryTeamsOFUser($userId){
    $sql = "SELECT  
b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, 
t.id as tid, t.team_name, t.created_at as team_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=t.created_by_id) as created_by_name_team, 
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members,
(SELECT COUNT(*) FROM team_projects tp WHERE tp.team_id=t.id AND tp.moved IS NULL) as num_projects
            FROM batches b, teams t, team_interns ti
            WHERE t.batch_id=b.id and ti.team_id=t.id and ti.intern_id=?
            ORDER BY t.team_name, t.created_at";
    $projects = getMultipleRecordsPDO($sql,'i',[$userId]);
    return $projects;
}

function getUserRoleProfileOfInternsInTeam($team_id)
{
    $users = array();
    $sql = "SELECT 
		u.id as uid, u.role_id as role_id, u.username, u.email, u.c_status, u.created_at, u.updated_at, 
        r.name as role, r.description as r_description, r.folder_name as user_folder, r.dt_row_color_class,
        p.id as pid, p.full_name, p.profile_picture 
            FROM users u, roles r, profiles p, team_interns ti
            WHERE ti.team_id=? AND ti.moved IS NULL AND ti.intern_id=u.id AND u.role_id=r.id AND p.user_id=u.id
            ";
    $users =  getMultipleRecordsPDO($sql,'i' ,[$team_id]);
    return $users;
}

/**
 * @param $teamId
 * @return array
 */
function getAllTeamMembers($teamId){
    $sql = "SELECT * 
            FROM team_interns ti, profiles p
            WHERE ti.intern_id=p.user_id AND ti.team_id=?";
    $batches = getMultipleRecordsPDO($sql,'i',[$teamId]);
    return $batches;
}

/**
 * @param $today_date_normal
 * @return array
 */
function getAllOngoingBatchTeams($today_date_normal){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at, 
       (SELECT p.full_name FROM profiles p WHERE p.user_id=b.created_by_id) as created_by_name,  b.created_by_id, 
       t.team_name,  t.id as tid, t.created_at as team_timestamp,
            (SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members,
            (SELECT COUNT(*) FROM team_projects tp WHERE tp.team_id=t.id AND tp.moved IS NULL) as current_proj
            FROM batches b, teams t
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND  t.batch_id=b.id
            ORDER BY t.created_at";
    $batches = getMultipleRecordsPDO($sql,'i',[$today_date_normal]);
    return $batches;
}

function getAllOnGoingTeams($today_date_normal){
    $sql = "SELECT  
b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, 
t.id as tid, t.team_name, t.created_at as team_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=t.created_by_id) as created_by_name_team, 
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members,
(SELECT COUNT(*) FROM team_projects tp WHERE tp.team_id=t.id AND tp.moved IS NULL) as num_projects
            FROM batches b, teams t
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND t.batch_id=b.id 
            ORDER BY t.team_name, t.created_at";
    $projects = getMultipleRecordsPDO($sql,'s',[$today_date_normal]);
    return $projects;
}
function getAllOnGoingTeamsOfUser($today_date_normal,$userId){
    $sql = "SELECT  
b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, 
t.id as tid, t.team_name, t.created_at as team_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=t.created_by_id) as created_by_name_team, 
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members,
(SELECT COUNT(*) FROM team_projects tp WHERE tp.team_id=t.id AND tp.moved IS NULL) as num_projects
            FROM batches b, teams t, team_interns ti
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND t.batch_id=b.id and ti.team_id=t.id and ti.intern_id=?
            ORDER BY t.team_name, t.created_at";
    $projects = getMultipleRecordsPDO($sql,'s',[$today_date_normal,$userId]);
    return $projects;
}

function getAllOnGoingTeamsOfBatch($batch_id){
    $sql = "SELECT  
b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at as batch_timestamp, 
t.id as tid, t.team_name, t.created_at as team_timestamp, (SELECT p.full_name FROM profiles p WHERE p.user_id=t.created_by_id) as created_by_name_team, 
(SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members,
(SELECT COUNT(*) FROM team_projects tp WHERE tp.team_id=t.id AND tp.moved IS NULL) as num_projects
            FROM batches b, teams t
            WHERE t.batch_id=? AND t.batch_id=b.id 
            ORDER BY t.team_name, t.created_at";
    $projects = getMultipleRecordsPDO($sql,'s',[$batch_id]);
    return $projects;
}

/** // to change interns from one batch to other batch
 * @param $batch_id_from
 * @return array
 */
function getAllInternsToChangeBatch($batch_id_from){
    $sql = "SELECT u.id as uid, u.role_id as role_id, u.username, u.email, u.password, u.c_status, u.created_at, u.updated_at, 
                    r.name as role, r.description as r_description, r.folder_name as user_folder,
                    p.id as pid, p.full_name, p.profile_picture 
            FROM users u, profiles p, roles r
            WHERE u.role_id=4 AND u.c_status=1 AND u.role_id=r.id AND p.user_id=u.id
                  AND u.id IN (SELECT bi.intern_id FROM batch_interns bi WHERE bi.batch_id=? AND bi.moved IS NULL)
                  ORDER BY p.full_name, u.created_at;
                  ";
    $interns = getMultipleRecordsPDO($sql,'i',[$batch_id_from]);
    return $interns;
}


/**
 * @param $today_date_normal
 * @param $userId
 * @return array
 */
function getParticularUserOngoingBatchTeams($today_date_normal, $userId){
    $sql = "SELECT  b.id as bid,  b.batch_name,  b.batch_year,  b.from_d_b,  b.to_d_b,  b.created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=b.created_by_id) as created_by_name,  b.created_by_id, t.team_name,  t.id as tid, t.created_at as team_timestamp,
            (SELECT COUNT(*) FROM team_interns ti WHERE ti.team_id=t.id AND ti.moved IS NULL) as num_members,
            (SELECT COUNT(*) FROM team_projects tp WHERE tp.team_id=t.id AND tp.moved IS NULL) as current_proj
            FROM batches b, teams t, team_interns ti
            WHERE (? BETWEEN b.from_d_b AND b.to_d_b) AND  t.batch_id=b.id and ti.intern_id=? and ti.team_id=t.id
            ORDER BY t.created_at";
    $batches = getMultipleRecordsPDO($sql,'i',[$today_date_normal,$userId]);
    return $batches;
}

/** // batch interns fetch to create team
 * @param $batch_id_from
 * @return array
 */
function getAllInternsToCreateTeam($batch_id_from){
    $sql = "SELECT u.id as uid, u.role_id as role_id, u.username, u.email, u.password, u.c_status, u.created_at, u.updated_at, 
                    r.name as role, r.description as r_description, r.folder_name as user_folder,
                    p.id as pid, p.full_name, p.profile_picture, (SELECT t.team_name FROM teams t, team_interns ti WHERE ti.team_id=t.id AND ti.intern_id=u.id AND ti.moved IS NULL) as team_name
            FROM users u, profiles p, roles r
            WHERE u.role_id=4 AND u.c_status=1 AND u.role_id=r.id AND p.user_id=u.id
                  AND u.id IN (SELECT bi.intern_id FROM batch_interns bi WHERE bi.batch_id=? AND bi.moved IS NULL)
                  ORDER BY p.full_name,u.created_at;
                  ";
    $interns = getMultipleRecordsPDO($sql,'i',[$batch_id_from]);
    return $interns;
}

// -------------------------------- ATTENDANCE ---------------------------------------------------------

/**
 * @param $atn_date
 * @param $batch_id
 * @param $intern_id
 * @param $status
 * @param $userId
 * @return bool
 */
function insertInternAttendance($atn_date, $batch_id, $intern_id, $status, $userId){
    $sql = "INSERT INTO batch_attendance (atn_date, batch_id, intern_id, status, created_by_id) VALUES (?,?,?,?,?)";
    $id =  modifyRecordPDO($sql, [$atn_date,$batch_id,$intern_id, $status, $userId]);
    return $id;
}

/** // get all interns of current batch for attendance
 * @param $batch_id_from
 * @return array
 */
function getAllInternsForAttendance($batch_id_from){
    $intern_role_id = role_id_intern;
    $sql = "SELECT u.id as uid, u.role_id as role_id, u.username, u.email, u.c_status, u.created_at, u.updated_at, 
                    r.name as role, r.description as r_description, r.folder_name as user_folder,
                    p.id as pid, p.full_name, p.profile_picture, (SELECT t.team_name FROM teams t, team_interns ti WHERE t.id=ti.team_id AND ti.intern_id=u.id AND ti.moved IS NULL LIMIT 1) as team_name
            FROM users u, profiles p, roles r
            WHERE u.role_id='$intern_role_id' AND u.c_status=1 AND u.role_id=r.id AND p.user_id=u.id
                  AND u.id IN (SELECT bi.intern_id FROM batch_interns bi WHERE bi.batch_id=? AND bi.moved IS NULL)
                  ORDER BY p.full_name, u.created_at
                  ";
    $interns = getMultipleRecordsPDO($sql,'i',[$batch_id_from]);
    return $interns;
}

function getAllInternsForAttendanceOfPastDate($atn_date, $batch_id_from){
    $sql = "SELECT u.id as uid, u.username, u.email, u.c_status, p.id as pid, p.full_name, p.profile_picture, (SELECT t.team_name FROM teams t, team_interns ti WHERE t.id=ti.team_id AND ti.intern_id=u.id AND ti.moved IS NULL LIMIT 1) as team_name  , ba.atn_date, ba.status, ba.id baid 
            FROM batch_attendance ba, users u, profiles p
            WHERE ba.atn_date=? AND ba.batch_id=? AND ba.intern_id=u.id AND p.user_id=u.id
            ORDER BY p.full_name
                  ";
    $interns = getMultipleRecordsPDO($sql,'si',[$atn_date, $batch_id_from]);
    return $interns;
}

/** // get particular for his attendance
 * @param $intern_id
 * @return mixed
 */
function getPartInternsForAttendance($intern_id){
    $sql = "SELECT u.id as uid, u.role_id as role_id, u.username, u.email, u.password, u.c_status, u.created_at, u.updated_at, 
                    r.name as role, r.description as r_description, r.folder_name as user_folder,
                    p.id as pid, p.full_name, p.profile_picture, (SELECT t.team_name FROM teams t, team_interns ti WHERE t.batch_id=u.id AND ti.intern_id=u.id AND ti.moved IS NULL) as team_name
            FROM users u, profiles p, roles r
            WHERE u.role_id=4 AND u.c_status=1 AND u.role_id=r.id AND p.user_id=u.id
                  AND u.id=?
                  ORDER BY created_at
                  ";
    $intern = getSingleRecordPDO($sql,[$intern_id]);
    return $intern;
}

/**
 * @param $attendance_date
 * @param $internId
 * @return mixed
 */
function getInternAttendance($attendance_date, $internId){
    $sql = "SELECT  * FROM batch_attendance ba WHERE ba.atn_date=?  AND ba.intern_id=? LIMIT 1";
    $intern_atd_row =  getSingleRecordPDO($sql, [$attendance_date,  $internId]);
    return $intern_atd_row;
}

/** // if attendance exist already
 * @param $batch_id_from
 * @param $intern_id
 * @param $atn_date
 * @return mixed
 */
function getBatchInternAttendance($batch_id_from, $intern_id, $atn_date){
        $sql = "SELECT u.email, p.full_name, ba.atn_date, ba.status
                FROM batch_attendance ba, profiles p, users u
                WHERE ba.batch_id=? AND ba.intern_id=? AND ba.atn_date=? AND ba.intern_id=u.id AND p.user_id=u.id  
                ORDER BY p.full_name, ba.atn_date
                  ";
    $interns = getSingleRecordPDO($sql,[$batch_id_from,$intern_id, $atn_date]);
    return $interns;
}

/** // interns list of interns whose attendance is already filled.
 * @param $batch_id_from
 * @param $from_d
 * @param $to_d
 * @return array
 */
function getBatchInternAttendanceForPastReport($batch_id_from, $from_d, $to_d){
    $sql = "SELECT  DISTINCT u.id as uid, u.email, p.full_name 
                FROM batch_attendance ba, users u, profiles p
                WHERE ba.intern_id=u.id AND p.user_id=u.id AND ba.batch_id=? AND (ba.atn_date BETWEEN ? AND ? )
                ORDER BY p.full_name ASC
                  ";
    $interns = getMultipleRecordsPDO($sql,'iss',[$batch_id_from,$from_d, $to_d]);
    return $interns;
}

/**
 * @param $from_d
 * @param $to_d
 * @param $batch_id_from
 * @return array
 */
function getInternsAttendanceConsolidateReport($from_d, $to_d, $batch_id_from){
    $sql = "    SELECT u.email, p.full_name,
                    COUNT(case when ba.atn_date>=? and ba.atn_date<=? and ba.status=1 then ba.atn_date end ) as t_present ,
                    COUNT(case when ba.atn_date>=? and ba.atn_date<=? and ba.status=-1 then ba.atn_date end ) as t_absent , 
                    COUNT(case when ba.atn_date>=? and ba.atn_date<=? and ba.status then ba.atn_date end ) as t_rows
                    FROM batch_attendance ba, profiles p, users u
                    WHERE ba.intern_id=u.id AND p.user_id=u.id AND ba.batch_id=?
                    GROUP BY u.id
                    ORDER BY p.full_name
                  ";
    $interns = getMultipleRecordsPDO($sql,'iiiiii',[$from_d,$to_d,$from_d,$to_d,$from_d,$to_d,$batch_id_from]);
    return $interns;
}

function getInternsAttendanceConsolidateReportOfIntern($from_d, $to_d, $batch_id_from, $userId){
    $sql = "    SELECT u.email, p.full_name,
                    COUNT(case when ba.atn_date>=? and ba.atn_date<=? and ba.status=1 then ba.atn_date end ) as t_present ,
                    COUNT(case when ba.atn_date>=? and ba.atn_date<=? and ba.status=-1 then ba.atn_date end ) as t_absent , 
                    COUNT(case when ba.atn_date>=? and ba.atn_date<=? and ba.status then ba.atn_date end ) as t_rows
                    FROM batch_attendance ba, profiles p, users u
                    WHERE ba.intern_id=u.id AND p.user_id=u.id AND ba.batch_id=? and u.id=?
                    GROUP BY u.id
                    ORDER BY p.full_name
                  ";
    $interns = getMultipleRecordsPDO($sql,'iiiiii',[$from_d,$to_d,$from_d,$to_d,$from_d,$to_d,$batch_id_from,$userId]);
    return $interns;
}


/** get all the attendance date to check if attendance exist in current month already
 * @param $attendance_date
 * @return array
 */
function getAllAtnDateToCheck($attendance_date){
    $sql = "SELECT DISTINCT atn_date FROM batch_attendance WHERE MONTH(atn_date)=MONTH('$attendance_date') "; //
    $atn_dates = getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC );
    return $atn_dates;
}

/**
 * @param $atd_status
 * @param $userID
 * @param $atn_row_id
 * @return bool
 */
function updateInternAttendance($atd_status, $userID, $atn_row_id){
    $sql = "UPDATE batch_attendance ba SET ba.status=?, ba.created_by_id=? WHERE ba.id=?";
    $result =  modifyRecordPDO($sql,[$atd_status, $userID, $atn_row_id]);
    return $result;
}

// ---------------------------------------------LEAVES -------------------------------------------
/**
 * @param $userId
 * @param $from_d
 * @param $to_d
 * @param $reason
 * @return bool
 */
function insertLeave($userId, $from_d, $to_d, $reason){
    global $pdo_conn;
    $sql = "INSERT INTO leaves (user_id, from_ldate, to_ldate, reason) VALUES (?,?,?,?)";
    $result =  modifyRecordPDO($sql, [$userId, $from_d, $to_d, $reason]);
    $inserted_id = $pdo_conn->lastInsertId();
    return $inserted_id;
}

/**
 * @param $status
 * @param $approved_id
 * @param $leave_id
 * @return bool
 */
function updateLeaveStatus($status, $approved_id, $leave_id ){
    $sql = "UPDATE leaves le SET le.approved=?, le.approved_by=?, le.adm_notify=-1, le.approved_time=current_timestamp WHERE le.id=?";
    $result =  modifyRecordPDO($sql,[$status,$approved_id,$leave_id ]);
    return $result;
}

// to notify the admin about the leave pending
function updateLeaveRequest($status, $leave_id ){
    $sql = "UPDATE leaves le SET le.adm_notify=? WHERE le.id=?";
    $result =  modifyRecordPDO($sql,[$status, $leave_id ]);
    return $result;
}

/**
 * @param $userId
 * @param $year_check
 * @return array
 */
function getUserLeave($userId, $year_check)
{
    $sql = "SELECT le.id, le.user_id, le.date_add, le.from_ldate, le.to_ldate, le.reason, le.approved, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.approved_by) as approved_by_name, le.approved_time, le.sms
            FROM leaves le 
            WHERE le.user_id=? AND YEAR(le.from_ldate)=? ";
    $leaves =  getMultipleRecordsPDO($sql, 'is' ,[$userId,$year_check]);
    return $leaves;
}

function getUserLeaveDetailsForPrint($leave_id)
{
    $sql = "SELECT le.id, le.user_id, le.date_add, le.from_ldate, le.to_ldate, le.reason, le.approved, le.approved_time, le.sms, 
u.email, 
p.full_name as intern_name, p.full_name as father_name, p.user_sign as intern_sign, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.approved_by) as approved_by_name, (SELECT p.user_sign FROM profiles p WHERE p.user_id=le.approved_by) as approved_by_sign,
 (SELECT b.batch_name FROM batches b WHERE b.id=bi.batch_id) as batch_name, (SELECT b.batch_year FROM batches b WHERE b.id=bi.batch_id) as batch_year, (SELECT b.from_d_b FROM batches b WHERE b.id=bi.batch_id) as from_d_b, (SELECT b.to_d_b FROM batches b WHERE b.id=bi.batch_id) as to_d_b
            FROM leaves le, users u, profiles p LEFT JOIN batch_interns bi ON p.user_id=bi.intern_id AND bi.moved IS NULL
            WHERE le.id=? AND u.id=le.user_id AND p.user_id=u.id LIMIT 1";
    $leave =  getSingleRecordPDO($sql,[$leave_id]);
    return $leave;
}

/**
 * @param $year_check
 * @return array
 */
function getAllUsersLeaves($year_check)
{
    $sql = "SELECT le.id, le.user_id, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.user_id) as leave_user_name, le.date_add, le.from_ldate, le.to_ldate, le.reason, le.approved, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.approved_by) as approved_by_name, le.approved_time, le.sms
            FROM leaves le 
            WHERE YEAR(le.from_ldate)=? AND le.approved IS NOT NULL
            ORDER BY le.from_ldate DESC";
    $leaves =  getMultipleRecordsPDO($sql, 'i' ,[$year_check]);
    return $leaves;
}

function getAllUsersLeavesOnToday($today_date_normal)
{
    $sql = "SELECT le.id, le.user_id, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.user_id) as leave_user_name, le.date_add, le.from_ldate, le.to_ldate, le.reason, le.approved, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.approved_by) as approved_by_name, le.approved_time, le.sms
            FROM leaves le 
            WHERE (? between le.from_ldate and le.to_ldate) AND le.approved=1
            ORDER BY le.from_ldate asc";
    $leaves =  getMultipleRecordsPDO($sql, 'i' ,[$today_date_normal]);
    return $leaves;
}

function getAllUsersLeavesOnTodayAndUpcoming($today_date_normal)
{
    $sql = "SELECT le.id, le.user_id, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.user_id) as leave_user_name, le.date_add, le.from_ldate, le.to_ldate, le.reason, le.approved, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.approved_by) as approved_by_name, le.approved_time, le.sms
            FROM leaves le 
            WHERE (? <le.from_ldate )
            ORDER BY le.from_ldate asc";
    $leaves =  getMultipleRecordsPDO($sql, 'i' ,[$today_date_normal]);
    return $leaves;
}

/**
 * @param $year_check
 * @return array
 */
function getAllUsersLeavesPending($year_check)
{
    $sql = "SELECT le.id, le.user_id, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.user_id) as leave_user_name, le.date_add, le.from_ldate, le.to_ldate, le.reason, le.approved, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.approved_by) as approved_by_name, le.approved_time, le.sms
            FROM leaves le 
            WHERE YEAR(le.from_ldate)=? AND le.approved IS NULL
            ORDER BY le.from_ldate";
    $leaves =  getMultipleRecordsPDO($sql, 'i' ,[$year_check]);
    return $leaves;
}

function getAllUsersLeavesPendingRequest($year_check)
{
    $sql = "SELECT le.id, le.user_id, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.user_id) as leave_user_name, le.date_add, le.from_ldate, le.to_ldate, le.reason, le.approved, (SELECT p.full_name FROM profiles p WHERE p.user_id=le.approved_by) as approved_by_name, le.approved_time, le.sms
            FROM leaves le 
            WHERE YEAR(le.from_ldate)=? AND le.approved IS NULL AND le.adm_notify=1
            ORDER BY le.from_ldate";
    $leaves =  getMultipleRecordsPDO($sql, 'i' ,[$year_check]);
    return $leaves;
}

//------------------------------------------

function insertTask($batchId, $toUser, $fromUser, $title, $desc, $projec_id, $deadline){
    $sql = "INSERT INTO tasks (batch_id, intern_id, from_id, title_, desc_, project_id, deadline) VALUES (?,?,?,?,?,?,?)";
    $result =  modifyRecordPDO($sql, [$batchId, $toUser, $fromUser, $title, $desc, $projec_id, $deadline]);
    return $result;
}

function updateTaskStatus($status, $reqStatus, $tsk_id ){
    $sql = "UPDATE tasks t SET t.status=?, t.request=? WHERE t.id=?";
    $result =  modifyRecordPDO($sql,[$status, $reqStatus, $tsk_id ]);
    return $result;
}


function updateTaskRequest($status, $tsk_id ){
    $sql = "UPDATE tasks t SET t.request=? WHERE t.id=?";
    $result =  modifyRecordPDO($sql,[$status, $tsk_id ]);
    return $result;
}

function updateTaskNotify($status, $tsk_id ){
    $sql = "UPDATE tasks t SET t.notify=? WHERE t.id=?";
    $result =  modifyRecordPDO($sql,[$status, $tsk_id ]);
    return $result;
}

function getAllTasks()
{
    $sql = "SELECT t.id as tkid, t.intern_id, t.from_id, t.title_, t.desc_,t.project_id, t.created_at, t.deadline, t.notify, t.status, t.request, t.requested_at,
(SELECT p.full_name FROM profiles p WHERE p.user_id=t.intern_id) as intern_name,  (SELECT p.full_name FROM profiles p WHERE p.user_id=t.from_id) as created_by_name,
(SELECT pj.project_name FROM projects pj WHERE pj.id=t.project_id) as project_name FROM tasks t
            ORDER BY t.title_, t.created_at";
    $tasks =  getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC);
    return $tasks;
}

function getAllTasksAccToStatus($status)
{
    $sql = "SELECT t.id as tkid, t.intern_id, t.from_id, t.title_, t.desc_,t.project_id, t.created_at, t.deadline, t.notify, t.status, t.request, t.requested_at,
(SELECT p.full_name FROM profiles p WHERE p.user_id=t.intern_id) as intern_name,  (SELECT p.full_name FROM profiles p WHERE p.user_id=t.from_id) as created_by_name,
(SELECT pj.project_name FROM projects pj WHERE pj.id=t.project_id) as project_name 
FROM tasks t
where t.status=?
            ORDER BY t.title_, t.created_at ";
    $tasks =  getMultipleRecordsPDO($sql,'i',[$status]);
    return $tasks;
}

function getAllTasksAccToStatusAndUser($status,$user)
{
    $sql = "SELECT t.id as tkid, t.intern_id, t.from_id, t.title_, t.desc_,t.project_id, t.created_at, t.deadline, t.notify, t.status, t.request, t.requested_at,
(SELECT p.full_name FROM profiles p WHERE p.user_id=t.intern_id) as intern_name,  (SELECT p.full_name FROM profiles p WHERE p.user_id=t.from_id) as created_by_name,
(SELECT pj.project_name FROM projects pj WHERE pj.id=t.project_id) as project_name 
FROM tasks t
where t.status=? AND t.intern_id=?
            ORDER BY t.title_, t.created_at ";
    $tasks =  getMultipleRecordsPDO($sql,'i',[$status, $user]);
    return $tasks;
}

function getAllTasksOfProject($project_id)
{
    $sql = "SELECT t.id as tkid, t.intern_id, t.from_id, t.title_, t.desc_,t.project_id, t.created_at, t.deadline, t.notify, t.status, t.request, t.requested_at,
(SELECT p.full_name FROM profiles p WHERE p.user_id=t.intern_id) as intern_name,  (SELECT p.full_name FROM profiles p WHERE p.user_id=t.from_id) as created_by_name,
(SELECT pj.project_name FROM projects pj WHERE pj.id=t.project_id) as project_name 
FROM tasks t
WHERE t.project_id=?
            ORDER BY t.created_at asc ";
    $tasks =  getMultipleRecordsPDO($sql,'i',[$project_id]);
    return $tasks;
}

function getAllTasksOfProjectByTaskId($task_id)
{
    $sql = "SELECT t.id as tkid, t.intern_id, t.from_id, t.title_, t.desc_,t.project_id, t.created_at, t.deadline, t.notify, t.status, t.request, t.requested_at,
(SELECT p.full_name FROM profiles p WHERE p.user_id=t.intern_id) as intern_name,  (SELECT p.full_name FROM profiles p WHERE p.user_id=t.from_id) as created_by_name,
(SELECT pj.project_name FROM projects pj WHERE pj.id=t.project_id) as project_name 
FROM tasks t
WHERE t.id=?
            ORDER BY t.created_at asc ";
    $tasks =  getSingleRecordPDO($sql,[$task_id]);
    return $tasks;
}

function getOnlyUserTasks($intern_id)
{
    $sql = "SELECT t.id as tkid, t.intern_id, t.from_id, t.title_, t.desc_,t.project_id, t.created_at, t.deadline, t.notify, t.status, t.request, t.requested_at,
            (SELECT p.full_name FROM profiles p WHERE p.user_id=t.intern_id) as intern_name,  
            (SELECT p.full_name FROM profiles p WHERE p.user_id=t.from_id) as created_by_name,
            (SELECT pj.project_name FROM projects pj WHERE pj.id=t.project_id) as project_name,
            (SELECT tm.team_name FROM teams tm, team_projects tp  WHERE tp.project_id=t.project_id AND tm.id=tp.team_id) as team_name
            FROM tasks t
            WHERE t.intern_id=?
            ORDER BY t.created_at asc";
    $tasks =  getMultipleRecordsPDO($sql,'i',[$intern_id]);
    return $tasks;
}

function getOnlyUserParticularTask($intern_id, $tsk_id)
{
    $sql = "SELECT t.id as tkid, t.intern_id, t.from_id, t.title_, t.desc_,t.project_id, t.created_at, t.deadline, t.notify, t.status, t.request, t.requested_at,
(SELECT p.full_name FROM profiles p WHERE p.user_id=t.intern_id) as intern_name,  (SELECT p.full_name FROM profiles p WHERE p.user_id=t.from_id) as created_by_name,
(SELECT pj.project_name FROM projects pj WHERE pj.id=t.project_id) as project_name FROM tasks t
WHERE t.intern_id=? AND t.id=? ";
    $tasks =  getSingleRecordPDO($sql,[$intern_id,$tsk_id]);
    return $tasks;
}

function getAllRequestedTasks()
{
    $sql = "SELECT t.id as tkid, t.intern_id, t.from_id, t.title_, t.desc_,t.project_id, t.created_at, t.deadline, t.notify, t.status, t.request, t.requested_at,
(SELECT p.full_name FROM profiles p WHERE p.user_id=t.intern_id) as intern_name,  (SELECT p.full_name FROM profiles p WHERE p.user_id=t.from_id) as created_by_name,
(SELECT pj.project_name FROM projects pj WHERE pj.id=t.project_id) as project_name FROM tasks t
WHERE t.request=1
            ORDER BY t.created_at asc";
    $tasks =  getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC);
    return $tasks;
}
function getAllRequestedTasksOfUser($intern_id)
{
    $sql = "SELECT t.id as tkid, t.intern_id, t.from_id, t.title_, t.desc_,t.project_id, t.created_at, t.deadline, t.notify, t.status, t.request, t.requested_at,
(SELECT p.full_name FROM profiles p WHERE p.user_id=t.intern_id) as intern_name,  (SELECT p.full_name FROM profiles p WHERE p.user_id=t.from_id) as created_by_name,
(SELECT pj.project_name FROM projects pj WHERE pj.id=t.project_id) as project_name FROM tasks t
WHERE t.notify=1 AND t.intern_id=?
            ORDER BY t.created_at asc";
    $tasks =  getMultipleRecordsPDO($sql,'s',[$intern_id]);
    return $tasks;
}

function getMimeType($filename)
{
    $mimetype = false;
    if(function_exists('finfo_open')) {
//        echo "1-";
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimetype = $finfo->file($filename);
        // open with FileInfo
    } elseif(function_exists('exif_imagetype')) {
//        echo "2-";
        $image_type = exif_imagetype($filename); // returns numbers png=3,jpg=2
        $mimetype = image_type_to_mime_type($image_type); // convert to mime type
        ;        // open with GD
    } elseif(function_exists('getimagesize')) {
        $size = getimagesize($filename);
        $mimetype = $size['mime'];
//        echo "3-";
        // open with EXIF
    } elseif(function_exists('mime_content_type')) {
//        echo "4-";
        $mimetype = mime_content_type($filename);
        echo $mimetype;
    }
    return $mimetype;
}

function getSingleRecordPDOReq($sql, $params) {
    global $pdo_conn;
    $conn= $pdo_conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $arr = $stmt->fetch();
//        if(!$arr) exit('NO Row');
    var_dump($arr);
    return $arr;
}
function getMultipleRecordsPDOReq($sql, $types = null, $params = []) {
    global $pdo_conn; $conn= $pdo_conn;
    $stmt = $conn->prepare($sql);
    if (!empty($params) && !empty($params)) { // parameters must exist before you call bind_param() method
        $stmt->execute($params);
    }
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($arr);
//        if(!$arr) exit('NO Rows');
    return $arr;
}
function getMultipleRecordsPDONoParaReq($sql,$fetch_type) {
    global $pdo_conn; $conn= $pdo_conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $arr = $stmt->fetchAll($fetch_type);
//        if(!$arr) exit('NO Rows!');
    var_dump($arr);
    return $arr;
}
function modifyRecordPDOReq($sql, $params) {
    global $pdo_conn; $conn= $pdo_conn;
    $result = $conn->prepare($sql)->execute($params);
    var_dump($result);
    return $result;
}

//function getParticularBatch($batch_id){
//    $sql = "SELECT id as bid, batch_name, batch_year, from_d_b, to_d_b, created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=batches.created_by_id) as created_by_name, created_by_id,
//            (SELECT COUNT(*) FROM batch_interns bi WHERE bi.batch_id=batches.id AND bi.moved IS NULL) as number_of_interns
//            FROM batches
//            WHERE batches.id = ? LIMIT 1";
//    $batch = getSingleRecordPDO($sql,[$batch_id]);
//    return $batch;
//}

//function getAllBatches(){
//    $sql = "SELECT id as bid, batch_name, batch_year, from_d_b, to_d_b, created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=batches.created_by_id) as created_by_name, created_by_id,
//            (SELECT EXTRACT(MONTH FROM batches.created_at) )as created_at_month
//            FROM batches";
//    $batches = getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC );
//    return $batches;
//}

//function getParticularUserBatch($user_id){
//    $sql = "SELECT b.id as bid, b.batch_name, b.batch_year, b.from_d_b, b.to_d_b, b.created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=b.created_by_id) as created_by_name, b.created_by_id
//            FROM batches b, batch_interns bi
//            WHERE b.id=bi.batch_id AND bi.intern_id=? LIMIT 1";
//    $batch = getSingleRecordPDO($sql,[$user_id]);
//    return $batch;
//}

//function getRecentBatches(){
//    $sql = "SELECT id as bid, batch_name, batch_year, from_d_b, to_d_b, created_at, (SELECT p.full_name FROM profiles p WHERE p.user_id=batches.created_by_id) as created_by_name, created_by_id,
//            (SELECT EXTRACT(MONTH FROM batches.created_at) )as created_at_month
//            FROM batches";
//    $batches = getMultipleRecordsPDONoPara($sql,PDO::FETCH_ASSOC );
//    return $batches;
//}


//function getRolePermissionsOfUser($userRoleId){
//    $sql = "SELECT
//                      p.name as permission_name
//                FROM permissions as p
//                JOIN permission_role as pr ON p.id=pr.permission_id
//                WHERE
//                  pr.role_id=?
//                ";
//    $user =  getMultipleRecordsPDO($sql, 'i', [$userRoleId]);
//    return $user;
//}



//function getUserDetails($userId)
//{
//    $sql = "SELECT id, role_id, username, email, profile_picture, created_at, updated_at, full_name, c_status, up_status FROM users WHERE id=? LIMIT 1";
//    $user =  getSingleRecordPDO($sql, [$userId]);
//    return $user;
//}

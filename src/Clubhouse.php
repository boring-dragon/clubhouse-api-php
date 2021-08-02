<?php

/**
 * Clubhouse Private API
 * @author Fadhiil Rachman <https://www.instagram.com/fadhiilrachman/>
 * @version 1.2.3
 * @license https://github.com/fadhiilrachman/clubhouse-api-php/blob/master/LICENSE The BSD-3-Clause License
 */

namespace FadhiilRachman\Clubhouse;

use \FadhiilRachman\Clubhouse\Requests;
use \FadhiilRachman\Clubhouse\ClubhouseException;

class Clubhouse extends Requests
{

    function __construct($phoneNumberOrAuthToken)
    {
        if (strlen($phoneNumberOrAuthToken) > 0 && strlen($phoneNumberOrAuthToken) <= 16) {
            $this->setPhoneNumber($phoneNumberOrAuthToken);
        } else {
            $this->loginWithAuthToken($phoneNumberOrAuthToken);
        }
    }

    public function startPhoneNumberAuth()
    {
        $post = [
            'phone_number' => $this->phone_number
        ];
        $request = $this->post('/start_phone_number_auth', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            if ($request['error_message'] !== null) throw new ClubhouseException($request['error_message'], 500);
        }
        return $request;
    }

    public function resendPhoneNumberAuth()
    {
        $post = [
            'phone_number' => $this->phone_number
        ];
        $request = $this->post('/resend_phone_number_auth', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            if ($request['error_message'] !== null) throw new ClubhouseException($request['error_message'], 500);
        }
        return $request;
    }

    public function callPhoneNumberAuth()
    {
        $post = [
            'phone_number' => $this->phone_number
        ];
        $request = $this->post('/call_phone_number_auth', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            if ($request['error_message'] !== null) throw new ClubhouseException($request['error_message'], 500);
        }
        return $request;
    }

    public function completePhoneNumberAuth($verification_code)
    {
        $post = [
            'phone_number' => $this->phone_number,
            'verification_code' => $verification_code
        ];
        $request = $this->post('/complete_phone_number_auth', $post);
        if (is_array($request) && array_key_exists('auth_token', $request)) {
            $this->logged_in($request);
        } else {
            throw new ClubhouseException('login failed', 500);
        }
        return $request;
    }

    public function refreshToken($refresh_token)
    {
        $this->required_login();
        $post = [
            'refresh_token' => $refresh_token
        ];
        $request = $this->post('/refresh_token', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('refresh token failed', 500);
        }
        return $request;
    }

    public function follow($user_id)
    {
        $this->required_login();
        $post = [
            'user_id' => $user_id,
            'user_ids' => null,
            'source' => 4,
            'source_topic_id' => null,
        ];
        $request = $this->post('/follow', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('follow failed', 500);
        }
        return $request;
    }

    public function unfollow($user_id)
    {
        $this->required_login();
        $post = [
            'user_id' => $user_id,
        ];
        $request = $this->post('/unfollow', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('unfollow failed', 500);
        }
        return $request;
    }

    public function followMultiple($user_ids = null)
    {
        $post = [
            'user_ids' => $user_ids,
            'user_id' => null,
            'source' => 7,
            'source_topic_id' => null,
        ];
        $request = $this->post('/follow_multiple', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('follow failed', 500);
        }
        return $request;
    }

    public function followClub($club_id)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
        ];
        $request = $this->post('/follow_club', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('follow club failed', 500);
        }
        return $request;
    }

    public function unfollowClub($club_id)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
        ];
        $request = $this->post('/unfollow_club', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('unfollow club failed', 500);
        }
        return $request;
    }

    public function block($user_id)
    {
        $this->required_login();
        $post = [
            'user_id' => $user_id,
        ];
        $request = $this->post('/block', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('block failed', 500);
        }
        return $request;
    }

    public function unblock($user_id)
    {
        $this->required_login();
        $post = [
            'user_id' => $user_id,
        ];
        $request = $this->post('/unblock', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('unblock failed', 500);
        }
        return $request;
    }

    public function me($return_blocked_ids = null, $timezone_identifier = 'Asia/Jakarta', $return_following_ids = null)
    {
        $this->required_login();
        $post = [
            'return_blocked_ids' => $return_blocked_ids,
            'timezone_identifier' => $timezone_identifier,
            'return_following_ids' => $return_following_ids
        ];
        $request = $this->post('/me', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('me failed', 500);
        }
        return $request;
    }

    public function addEmail($email)
    {
        $this->required_login();
        $post = [
            'email' => $email
        ];
        $request = $this->post('/add_email', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('add email failed', 500);
        }
        return $request;
    }

    public function updateUsername($username)
    {
        $this->required_login();
        $post = [
            'username' => $username
        ];
        $request = $this->post('/update_username', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('update username failed', 500);
        }
        return $request;
    }

    public function updateName($name)
    {
        $this->required_login();
        $post = [
            'name' => $name
        ];
        $request = $this->post('/update_name', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('update name failed', 500);
        }
        return $request;
    }

    public function updateBio($bio)
    {
        $this->required_login();
        $post = [
            'bio' => $bio
        ];
        $request = $this->post('/update_bio', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('update bio failed', 500);
        }
        return $request;
    }

    public function updatePhoto($file_path)
    {
        $this->required_login();;
        $request = $this->upload('/update_photo', $file_path);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('update photo failed', 500);
        }
        return $request;
    }

    public function addUserTopic($club_id = null, $topic_id = null)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
            'topic_id' => $topic_id
        ];
        $request = $this->post('/add_user_topic', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('add user topic failed', 500);
        }
        return $request;
    }

    public function removeUserTopic($club_id = null, $topic_id = null)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
            'topic_id' => $topic_id
        ];
        $request = $this->post('/remove_user_topic', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('remove user topic failed', 500);
        }
        return $request;
    }

    public function checkWaitlistStatus()
    {
        $this->required_login();
        $request = $this->post('/check_waitlist_status');
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('check waitlist status failed', 500);
        }
        return $request;
    }

    public function inviteFromWhitelist($user_id)
    {
        $this->required_login();
        $post = [
            'user_id' => $user_id,
        ];
        $request = $this->post('/invite_from_waitlist', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('invite from waitlist failed', 500);
        }
        return $request;
    }

    public function inviteToApp($phone_number, $name = 'Clubhouse User')
    {
        $this->required_login();
        $post = [
            'name' => $name,
            'phone_number' => $phone_number
        ];
        $request = $this->post('/invite_to_app', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('invite to app failed', 500);
        }
        return $request;
    }

    public function getSettings()
    {
        $this->required_login();
        $request = $this->get('/get_settings');
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get settings failed', 500);
        }
        return $request;
    }

    public function getOnlineFriends()
    {
        $this->required_login();
        $request = $this->get('/get_online_friends');
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get online friends failed', 500);
        }
        return $request;
    }

    public function getActionableNotifications()
    {
        $this->required_login();
        $request = $this->get('/get_actionable_notifications');
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get actionable notifications failed', 500);
        }
        return $request;
    }

    public function getCreateChannelTargets()
    {
        $this->required_login();
        $request = $this->get('/get_create_channel_targets');
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get create channel targets failed', 500);
        }
        return $request;
    }

    public function getProfile($user_id)
    {
        $this->required_login();
        $post = [
            'user_id' => $user_id
        ];
        $request = $this->post('/get_profile', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get profile failed', 500);
        }
        return $request;
    }

    public function getNotifications($page_size = 20, $page = 1)
    {
        $this->required_login();
        $param = [
            'page_size' => $page_size,
            'page' => $page
        ];
        $request = $this->get('/get_notifications', $param);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get notifications failed', 500);
        }
        return $request;
    }

    public function getFollowing($user_id, $page_size = 50, $page = 1)
    {
        $this->required_login();
        $param = [
            'user_id' => $user_id,
            'page_size' => $page_size,
            'page' => $page
        ];
        $request = $this->get('/get_following', $param);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get following failed', 500);
        }
        return $request;
    }

    public function getFollowers($user_id, $page_size = 50, $page = 1)
    {
        $this->required_login();
        $param = [
            'user_id' => $user_id,
            'page_size' => $page_size,
            'page' => $page
        ];
        $request = $this->get('/get_followers', $param);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get followers failed', 500);
        }
        return $request;
    }

    public function getMutualFollows($user_id, $page_size = 50, $page = 1)
    {
        $this->required_login();
        $param = [
            'user_id' => $user_id,
            'page_size' => $page_size,
            'page' => $page
        ];
        $request = $this->get('/get_mutual_follows', $param);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get mutual follows failed', 500);
        }
        return $request;
    }

    public function searchUsers($query, $followers_only = false, $following_only = false, $cofollows_only = false)
    {
        $this->required_login();
        $post = [
            'query' => $query,
            'followers_only' => $followers_only,
            'following_only' => $following_only,
            'cofollows_only' => $cofollows_only
        ];
        $request = $this->post('/search_users', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('search users failed', 500);
        }
        return $request;
    }

    public function searchClubs($query, $followers_only = false, $following_only = false, $cofollows_only = false)
    {
        $this->required_login();
        $post = [
            'query' => $query,
            'followers_only' => $followers_only,
            'following_only' => $following_only,
            'cofollows_only' => $cofollows_only
        ];
        $request = $this->post('/search_clubs', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('search clubs failed', 500);
        }
        return $request;
    }

    public function getEvents($is_filtered = true, $page_size = 25, $page = 1)
    {
        $this->required_login();
        $param = [
            'is_filtered' => $is_filtered,
            'page_size' => $page_size,
            'page' => $page
        ];
        $request = $this->get('/get_events', $param);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get events failed', 500);
        }
        return $request;
    }

    public function getEvent($event_id = null, $user_ids = null, $club_id = null)
    {
        $this->required_login();
        $post = [
            'event_id' => $event_id,
            'user_ids' => $user_ids,
            'club_id' => $club_id,
            'is_member_only' => false,
            'event_hashid' => null,
            'description' => null,
            'time_start_epoch' => null,
            'name' => null
        ];
        $request = $this->post('/get_event', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get event failed', 500);
        }
        return $request;
    }

    public function createEvent($name = null, $description = null, $time_start_epoch = null, $user_ids = null, $club_id = null, $is_member_only = false, $event_hashid = null, $event_id = null)
    {
        $this->required_login();
        $post = [
            'event_id' => $event_id,
            'user_ids' => $user_ids,
            'club_id' => $club_id,
            'is_member_only' => $is_member_only,
            'event_hashid' => $event_hashid,
            'description' => $description,
            'time_start_epoch' => $time_start_epoch,
            'name' => $name
        ];
        $request = $this->post('/create_event', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('create event failed', 500);
        }
        return $request;
    }

    public function editEvent($event_id = null, $name = null, $description = null, $time_start_epoch = null, $user_ids = null, $club_id = null, $is_member_only = false, $event_hashid = null)
    {
        $this->required_login();
        $post = [
            'event_id' => $event_id,
            'user_ids' => $user_ids,
            'club_id' => $club_id,
            'is_member_only' => $is_member_only,
            'event_hashid' => $event_hashid,
            'description' => $description,
            'time_start_epoch' => $time_start_epoch,
            'name' => $name
        ];
        $request = $this->post('/edit_event', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('edit event failed', 500);
        }
        return $request;
    }

    public function deleteEvent($event_id = null)
    {
        $this->required_login();
        $post = [
            'event_id' => $event_id,
            'user_ids' => null,
            'club_id' => null,
            'is_member_only' => false,
            'event_hashid' => null,
            'description' => null,
            'time_start_epoch' => null,
            'name' => null
        ];
        $request = $this->post('/delete_event', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('delete event failed', 500);
        }
        return $request;
    }

    public function getAllTopics()
    {
        $this->required_login();
        $request = $this->get('/get_all_topics');
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get all topics failed', 500);
        }
        return $request;
    }

    public function getTopic($topic_id)
    {
        $this->required_login();
        $post = [
            'topic_id' => $topic_id
        ];
        $request = $this->post('/get_topic', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get topic failed', 500);
        }
        return $request;
    }

    public function getUsersForTopic($topic_id, $page_size = 25, $page = 1)
    {
        $this->required_login();
        $param = [
            'topic_id' => $topic_id,
            'page_size' => $page_size,
            'page' => $page
        ];
        $request = $this->get('/get_users_for_topic', $param);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get users for topic failed', 500);
        }
        return $request;
    }

    public function getClubsForTopic($topic_id, $page_size = 25, $page = 1)
    {
        $this->required_login();
        $param = [
            'topic_id' => $topic_id,
            'page_size' => $page_size,
            'page' => $page
        ];
        $request = $this->get('/get_clubs_for_topic', $param);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get clubs for topic failed', 500);
        }
        return $request;
    }

    public function getClub($club_id)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
            'source_topic_id' => null
        ];
        $request = $this->post('/get_club', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get club failed', 500);
        }
        return $request;
    }

    public function getClubMembers($club_id, $return_followers = false, $return_members = true, $page_size = 50, $page = 1)
    {
        $this->required_login();
        $param = [
            'club_id' => $club_id,
            'return_followers' => $return_followers,
            'return_members' => $return_members,
            'page_size' => $page_size,
            'page' => $page
        ];
        $request = $this->get('/get_club_members', $param);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get club members failed', 500);
        }
        return $request;
    }

    public function acceptClubMemberInvite($club_id)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
            'source_topic_id' => null
        ];
        $request = $this->post('/accept_club_member_invite', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('accept club member invite failed', 500);
        }
        return $request;
    }

    public function addClubAdmin($club_id, $user_id)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
            'user_id' => $user_id
        ];
        $request = $this->post('/add_club_admin', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('add club admin failed', 500);
        }
        return $request;
    }

    public function removeClubAdmin($club_id, $user_id)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
            'user_id' => $user_id
        ];
        $request = $this->post('/remove_club_admin', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('remove club admin failed', 500);
        }
        return $request;
    }

    public function addClubMember($club_id, $user_id)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
            'user_id' => $user_id
        ];
        $request = $this->post('/add_club_member', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('add club member failed', 500);
        }
        return $request;
    }

    public function removeClubMember($club_id, $user_id)
    {
        $this->required_login();
        $post = [
            'club_id' => $club_id,
            'user_id' => $user_id
        ];
        $request = $this->post('/remove_club_member', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('remove club member failed', 500);
        }
        return $request;
    }

    public function getChannel($channel)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'channel_id' => null
        ];
        $request = $this->post('/get_channel', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get channel failed', 500);
        }
        return $request;
    }

    public function getChannels()
    {
        $this->required_login();
        $request = $this->get('/get_channels');
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get channels failed', 500);
        }
        return $request;
    }

    public function hideChannel($channel, $hide = true)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'hide' => $hide
        ];
        $request = $this->post('/hide_channel', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('hide channel failed', 500);
        }
        return $request;
    }

    public function joinChannel($channel)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'attribution_source' => 'feed',
            'attribution_details' => base64_encode(json_encode(
                ['is_explore' => false, 'rank' => 1]
            ))
        ];
        $request = $this->post('/join_channel', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('join channel failed', 500);
        }
        return $request;
    }

    public function leaveChannel($channel)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'channel_id' => null
        ];
        $request = $this->post('/leave_channel', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('leave channel failed', 500);
        }
        return $request;
    }

    public function createChannel($topic = '', $user_ids = [], $is_private = false, $is_social_mode = false)
    {
        $this->required_login();
        $post = [
            'topic' => $topic,
            'user_ids' => $user_ids,
            'is_private' => $is_private,
            'is_social_mode' => $is_social_mode
        ];
        $request = $this->post('/create_channel', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('create channel failed', 500);
        }
        return $request;
    }

    public function endChannel($channel)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'channel_id' => null
        ];
        $request = $this->post('/end_channel', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('end channel failed', 500);
        }
        return $request;
    }

    public function activePing($channel)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'channel_id' => null
        ];
        $request = $this->post('/active_ping', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('active ping failed', 500);
        }
        return $request;
    }

    public function inviteToNewChannel($user_id, $channel)
    {
        $this->required_login();
        $post = [
            'user_id' => $user_id,
            'channel' => $channel
        ];
        $request = $this->post('/invite_to_new_channel', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('invite to new channel failed', 500);
        }
        return $request;
    }

    public function acceptNewChannelInvite($channel_invite_id)
    {
        $this->required_login();
        $post = [
            'channel_invite_id' => $channel_invite_id
        ];
        $request = $this->post('/accept_new_channel_invite', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('accept new channel invite failed', 500);
        }
        return $request;
    }

    public function rejectNewChannelInvite($channel_invite_id)
    {
        $this->required_login();
        $post = [
            'channel_invite_id' => $channel_invite_id
        ];
        $request = $this->post('/reject_new_channel_invite', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('reject new channel invite failed', 500);
        }
        return $request;
    }

    public function cancelNewChannelInvite($channel_invite_id)
    {
        $this->required_login();
        $post = [
            'channel_invite_id' => $channel_invite_id
        ];
        $request = $this->post('/cancel_new_channel_invite', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('cancel new channel invite failed', 500);
        }
        return $request;
    }

    public function getSuggestedSpeakers($channel)
    {
        $this->required_login();
        $post = [
            'channel' => $channel
        ];
        $request = $this->post('/get_suggested_speakers', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get suggested speakers failed', 500);
        }
        return $request;
    }

    public function audienceReply($channel, $raise_hands = true, $unraise_hands = false)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'raise_hands' => $raise_hands,
            'unraise_hands' => $unraise_hands
        ];
        $request = $this->post('/audience_reply', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('audience reply failed', 500);
        }
        return $request;
    }

    public function changeHandraiseSettings($channel, $is_enabled = true, $handraise_permission = 1)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'is_enabled' => $is_enabled,
            'handraise_permission' => $handraise_permission
        ];
        $request = $this->post('/change_handraise_settings', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('change_handraise_settings failed', 500);
        }
        return $request;
    }

    public function updateSkintone($channel, $skintone = 1)
    {
        $this->required_login();
        if ($skintone < 1 && $skintone > 5) {
            $skintone = 1;
        }
        $post = [
            'skintone' => $skintone
        ];
        $request = $this->post('/update_skintone', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('update skintone failed', 500);
        }
        return $request;
    }

    public function makeChannelPublic($channel)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'channel_id' => null
        ];
        $request = $this->post('/make_channel_public', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('make channel public failed', 500);
        }
        return $request;
    }

    public function makeChannelSocial($channel)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'channel_id' => null
        ];
        $request = $this->post('/make_channel_social', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('make channel social failed', 500);
        }
        return $request;
    }

    public function makeModerator($channel, $user_id)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'user_id' => $user_id
        ];
        $request = $this->post('/make_moderator', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('make moderator failed', 500);
        }
        return $request;
    }

    public function blockFromChannel($channel, $user_id)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'user_id' => $user_id
        ];
        $request = $this->post('/block_from_channel', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('block from channel failed', 500);
        }
        return $request;
    }

    public function acceptSpeakerInvite($channel, $user_id)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'user_id' => $user_id
        ];
        $request = $this->post('/accept_speaker_invite', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('accept speaker invite failed', 500);
        }
        return $request;
    }

    public function rejectSpeakerInvite($channel, $user_id)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'user_id' => $user_id
        ];
        $request = $this->post('/reject_speaker_invite', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('reject speaker invite failed', 500);
        }
        return $request;
    }

    public function inviteSpeaker($channel, $user_id)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'user_id' => $user_id
        ];
        $request = $this->post('/invite_speaker', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('invite speaker failed', 500);
        }
        return $request;
    }

    public function uninviteSpeaker($channel, $user_id)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'user_id' => $user_id
        ];
        $request = $this->post('/uninvite_speaker', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('uninvite speaker failed', 500);
        }
        return $request;
    }

    public function muteSpeaker($channel, $user_id)
    {
        $this->required_login();
        $post = [
            'channel' => $channel,
            'user_id' => $user_id
        ];
        $request = $this->post('/mute_speaker', $post);
        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('mute speaker failed', 500);
        }
        return $request;
    }

    public function checkForUpdate(bool $is_testflight = false)
    {
        $this->required_login();

        $param = [
            'is_testflight' => $is_testflight
        ];

        $request = $this->get('/check_for_update', $param);

        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('check for update failed', 500);
        }

        return $request;
    }

    public function getSuggestedFollowsSimilar($user_id, $username)
    {
        $this->required_login();

        $post = [
            'user_id' => $user_id,
            'username' => $username,
            'query_id' => null,
            'query_result_position' => null
        ];

        $request = $this->post('/get_release_notes', $post);

        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get suggested follows similar failed', 500);
        }

        return $request;
    }

    public function getSuggestedFollowsAll($in_onboarding = true, $page_size = 50, $page = 1)
    {
        $this->required_login();

        $param = [
            'in_onboarding' => $in_onboarding,
            'page_size' => $page_size,
            'page' => $page
        ];

        $request = $this->get('/get_suggested_follows_all', $param);

        if (is_array($request) && array_key_exists('error_message', $request)) {
            throw new ClubhouseException('get suggested follows all failed', 500);
        }

        return $request;
    }
}

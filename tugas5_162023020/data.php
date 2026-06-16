<?php

define('DATA_FILE', __DIR__ . '/users.json');

// Ambil semua data users
function getUsers() {
    if (!file_exists(DATA_FILE)) {
        file_put_contents(DATA_FILE, json_encode([]));
    }
    $json = file_get_contents(DATA_FILE);
    return json_decode($json, true) ?: [];
}

// Simpan semua data users
function saveUsers($users) {
    file_put_contents(DATA_FILE, json_encode(array_values($users), JSON_PRETTY_PRINT));
}

// Ambil user berdasarkan ID
function getUserById($id) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['id'] == $id) {
            return $user;
        }
    }
    return null;
}

// Generate ID baru (auto increment)
function getNextId() {
    $users = getUsers();
    if (empty($users)) return 1;
    $maxId = 0;
    foreach ($users as $u) {
        if ($u['id'] > $maxId) $maxId = $u['id'];
    }
    return $maxId + 1;
}

// Cek apakah username sudah ada (exclude ID tertentu)
function isUsernameTaken($username, $excludeId = null) {
    $users = getUsers();
    foreach ($users as $user) {
        if (strtolower($user['username']) === strtolower($username)) {
            if ($excludeId !== null && $user['id'] == $excludeId) continue;
            return true;
        }
    }
    return false;
}

// Cek apakah email sudah ada (exclude ID tertentu)
function isEmailTaken($email, $excludeId = null) {
    $users = getUsers();
    foreach ($users as $user) {
        if (strtolower($user['email']) === strtolower($email)) {
            if ($excludeId !== null && $user['id'] == $excludeId) continue;
            return true;
        }
    }
    return false;
}

// Tambah user baru
function addUser($username, $email) {
    $users = getUsers();
    $users[] = [
        'id' => getNextId(),
        'username' => $username,
        'email' => $email
    ];
    saveUsers($users);
}

// Update user
function updateUser($id, $username, $email) {
    $users = getUsers();
    foreach ($users as &$user) {
        if ($user['id'] == $id) {
            $user['username'] = $username;
            $user['email'] = $email;
            break;
        }
    }
    saveUsers($users);
}

// Hapus user
function deleteUser($id) {
    $users = getUsers();
    $users = array_filter($users, function($u) use ($id) {
        return $u['id'] != $id;
    });
    saveUsers($users);
}
?>

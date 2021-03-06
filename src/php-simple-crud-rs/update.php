<?php
require __DIR__ . '/users/users.php';

if (!isset($_GET['id'])) {
    include './partials/notFound.php';
    exit;
}
$userId = $_GET['id'];

$user = getUserById($userId);

if (!$user) {
    include './partials/notFound.php';
    exit;
}

$errors = [
    'name' => '',
    'username' => '',
    'email' => '',
    'phone' => '',
    'website' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = array_merge($user, $_POST);
    $isValid = validateUser($user, $errors);

    if ($isValid) {
        $user = updateUser($_POST, $userId);
        uploadImage($_FILES['picture'], $user);
        header("Location: index.php");
    }
}
include './partials/header.php';
?>

<?php include './_form.php' ?>

<?php include './partials/footer.php' ?>
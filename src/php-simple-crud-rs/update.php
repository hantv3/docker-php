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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = updateUser($_POST, $userId);
    if (isset($_FILES['picture'])) {
        // check exit directory images
        if (!is_dir(__DIR__ . "/users/images")) {
            mkdir(__DIR__ . "/users/images");
        }

        // Get file extension from the filename
        $fileName = $_FILES['picture']['name'];
        // Search for the dot in the filename
        $dotPosition = strrpos($fileName, '.');
        // Take the substring from the dot position till the end of the string
        $extension = substr($fileName, $dotPosition + 1);

        move_uploaded_file($_FILES['picture']['tmp_name'], __DIR__ . "/users/images/$userId.$extension");
        $user['extension'] = $extension;
        updateUser($user, $userId);
    }
    header("Location: index.php");
}
include './partials/header.php';
?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update user <b><?php echo $user['name'] ?></b></h3>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" value="<?php echo $user['name'] ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" value="<?php echo $user['username'] ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" value="<?php echo $user['email'] ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" name="phone" value="<?php echo $user['phone'] ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Website</label>
                    <input type="text" name="website" value="<?php echo $user['website'] ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" name="picture" class="form-control-file">
                </div>

                <button class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php include './partials/footer.php' ?>
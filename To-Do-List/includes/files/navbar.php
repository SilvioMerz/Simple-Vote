<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="mr-auto ml-3">
        <a class="navbar-brand" href="http://localhost/To-Do-List/sites/main.php">To-Do-List</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse w-100 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="http://localhost/To-Do-List/sites/main.php">Home</a>
            </li>
            <li class="nav-item active">
                <a style="cursor: pointer" class="nav-link" data-toggle="modal" data-target="#createListModal">Create New List</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link">Logged in as: <?= $_SESSION['user']['username']?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/To-Do-List/index.php?logout=true"><i class="fas fa-sign-out-alt" data-toggle="tooltip"
                                                                     data-placement="bottom" title="Sign Out"></i></a>
            </li>
        </ul>
    </div>
</nav>
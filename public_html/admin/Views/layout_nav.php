
        <div class="col-1">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" style="color: #000; background-color: #FFF;">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <h6 class="dropdown-header">Hello, <?php echo $_SESSION['user']["firstName"]; ?></h6>
                    <a class="dropdown-item" href="/admin/messages">main</a>
                    <a class="dropdown-item" href="/admin/subscribers">subscribers</a>
                    <a class="dropdown-item" href="/admin/logout">logout</a>

                    <script src="https://use.fontawesome.com/bb724fcb2e.js"></script>
                </div>

            </div>
        </div>
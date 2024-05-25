<?php 
    $current_page = basename($_SERVER['REQUEST_URI'], ".php"); 
?>

<footer class="article-container-footer">
    <a href="<?php echo $base_url ;?>index" class="text-decoration-none">
        <button class="button is-ghost text-secondary d-flex flex-column align-items-center" <?php echo $current_page == 'index' ? 'style = "background-color: #dfdad7; color: black !important""' : ''; ?>>
            <i class="fa fa-home fs-4 me-1"></i>
            <span>Home</span>
        </button>
    </a>
    <a href="<?php echo $base_url ;?>knowledge" class="text-decoration-none">
        <button class="button is-ghost text-secondary d-flex flex-column align-items-center" <?php echo $current_page == 'knowledge' ? 'style = "background-color: #dfdad7; color: black !important""' : ''; ?>>
            <i class="fa fa-newspaper-o fs-4 me-1"></i>
            <span>Knowledge</span>
        </button>
    </a>
    <button class="button is-ghost text-secondary d-flex flex-column align-items-center" <?php echo $current_page == 'likes' ? 'style = "background-color: #dfdad7; color: black !important""' : ''; ?>>
    <i class="fa fa-heart fs-4 me-1"></i>
    <span>Likes</span>
    </button>
    <button class="button is-ghost text-secondary d-flex flex-column align-items-center" <?php echo $current_page == 'chats' ? 'style = "background-color: #dfdad7; color: black !important""' : ''; ?>>
    <i class="fa fa-commenting fs-4 me-1"></i>
    <span>Chats</span>
    </button>
    <a href="<?php echo $base_url ;?>profile" class="text-decoration-none">
        <button class="button is-ghost text-secondary d-flex flex-column align-items-center " <?php echo $current_page == 'profile' ? 'style = "background-color: #dfdad7; color: black !important"' : ''; ?>>
            <i class="fa fa-user fs-4 me-1"></i>
            <span>Profile</span>
        </button>
    </a>
</footer>
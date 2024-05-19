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
    <button class="button is-ghost text-secondary d-flex flex-column align-items-center" <?php echo $current_page == 'encounter' ? 'style = "background-color: #dfdad7; color: black !important""' : ''; ?>>
    <svg
        data-origin="pipeline"
        aria-hidden="true"
        viewBox="0 0 32 32"
        fill="none"
        width="25px"
    >
        <path
        d="M11.945 26.806a7.713 7.713 0 01-4.88-9.752l4.013-12.05a.665.665 0 00-.766-.865 4.82 4.82 0 00-.42.12l-6.45 2.15a5.03 5.03 0 00-1.404.73h-.002A5.03 5.03 0 000 11.183v.002c0 .54.087 1.078.258 1.59l4.826 14.479c.164.492.407.956.718 1.371a5.1 5.1 0 004.042 2.046h.012a5.03 5.03 0 001.586-.256l3.778-1.255a.666.666 0 000-1.265l-3.275-1.088z"
        fill="currentColor"
        ></path>
        <path
        d="M28.654 3.157a5.031 5.031 0 00-1.428-.749L20.774.258a5.03 5.03 0 00-6.365 3.183L9.595 17.896a5.032 5.032 0 00-.258 1.582v.012a5.031 5.031 0 001.999 4.023l.003.002c.438.33.926.587 1.447.76l6.438 2.139a5.03 5.03 0 001.586.256h.012a5.032 5.032 0 004.018-2.012l.003-.005c.325-.432.578-.915.748-1.427l4.817-14.451c.171-.513.259-1.05.259-1.591v-.002a5.031 5.031 0 00-2.013-4.025z"
        fill="currentColor"
        ></path>
    </svg>
    Encounter
    </button>
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
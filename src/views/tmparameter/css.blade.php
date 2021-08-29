<style>
    select {
        font-family: 'FontAwesome', 'Second Font name'
    }

    @media (min-width: 576px) {
        .rounded-nav {
            border-radius: 50rem !important;
        }
    }

    @media (min-width: 576px) {
        .rounded-nav .nav-link {
            border-radius: 50rem !important;
        }
    }

    /* With arrow tabs */

    .with-arrow .nav-link.active {
        position: relative;
    }

    .with-arrow .nav-link.active::after {
        content: '';
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #2b90d9;
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        display: block;
    }

    /* lined tabs */

    .lined .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
    }

    .lined .nav-link:hover {
        border: none;
        border-bottom: 3px solid transparent;
    }

    .lined .nav-link.active {
        background: none;
        color: #555;
        border-color: #2b90d9;
    }

</style>

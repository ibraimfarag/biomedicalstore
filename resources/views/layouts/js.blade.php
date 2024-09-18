<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js" integrity="sha512-TPh2Oxlg1zp+kz3nFA0C5vVC6leG/6mm1z9+mA81MI5eaUVqasPLO8Cuk4gMF4gUfP5etR73rgU/8PNMsSesoQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.querySelector('.sidebar');

    // Show scrollbar when scrolling
    sidebar.addEventListener('scroll', function() {
        sidebar.classList.add('scrolling');
        clearTimeout(sidebar.scrollTimeout);
        sidebar.scrollTimeout = setTimeout(() => {
            sidebar.classList.remove('scrolling');
        }, 1000); // Scrollbar hides 1 second after scrolling stops
    });
});
</script>

@yield('content-js')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editProfileButton = document.querySelector('.dropdown-item[href="{{ route('profile.edit') }}"]');
        
        if (editProfileButton) {
            editProfileButton.addEventListener('click', function(event) {
                event.preventDefault();
                const editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
                editProfileModal.show();
            });
        }
    });
</script>

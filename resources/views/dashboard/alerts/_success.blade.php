@if (session()->has('success'))
    <script>
        function not_success() {
            new notif({
                msg: "{{ session()->get('success') }}",
                position: "right",
                type: "success"
            });
        }
        not_success();
    </script>
@endif


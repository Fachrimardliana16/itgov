<div class="reveal-modal">
    <div class="modal-header">
        <h5>Reveal Credential</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form id="reveal-credential-form">
            <div class="mb-3">
                <label for="reveal-password" class="form-label">Enter your password to reveal credentials</label>
                <input type="password" class="form-control" id="reveal-password" name="password" required>
                <small class="text-muted">Password will auto-mask after 15 seconds</small>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="reveal-credential-btn">Reveal</button>
    </div>
</div>

<script>
$(document).ready(function() {
    let timeoutId = null;
    
    $('#reveal-credential-btn').on('click', function() {
        const password = $('#reveal-password').val();
        
        $.ajax({
            url: '/vault/reveal',
            type: 'POST',
            data: { password: password, _token: '{{ csrf_token() }}' },
            dataType: 'json',
            success: function(response) {
                // Display the decrypted credentials
                $('#credential-username').text(response.username);
                $('#credential-password').text(response.password);
                $('#credential-additional').text(response.additional_secret || '-');
                $('#credential-notes').text(response.notes || '-');
                
                // Show the modal
                $('#credential-reveal-modal').modal('show');
                
                // Set timer to auto-mask after 15 seconds
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
                timeoutId = setTimeout(function() {
                    $('#credential-username').text('** masked **');
                    $('#credential-password').text('** masked **');
                    $('#credential-additional').text('** masked **');
                    $('#credential-notes').text('** masked **');
                }, 15000);
                
                // Clear memory after timeout
                setTimeout(function() {
                    $.ajax({
                        url: '/vault/clear-memory',
                        type: 'POST',
                        success: function() {}
                    });
                }, 20000);
            },
            error: function(xhr) {
                alert('Password verification failed. Please try again.');
                $('#reveal-password').val('');
            }
        });
    });
});
</script>
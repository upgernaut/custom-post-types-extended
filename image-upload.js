jQuery(document).ready(function($){
    // Field fo pdf's in general settings
    $('.fileUploadField').click(function(e) {
        var fileUploaderVar;
        e.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (fileUploaderVar) {
            fileUploaderVar.open();
            return;
        }
        
        //Extend the wp.media object
        fileUploaderVar = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false,
            displaySettings: true,
            displayUserSettings: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        var $this = $(this);
        fileUploaderVar.on('select', function() {
            attachment = fileUploaderVar.state().get('selection').first().toJSON().url;            
            $this.closest('td').find('input[type=text]').val( attachment);

                    
        });

        //Open the uploader dialog
        fileUploaderVar.open();
    });    
    
    
    
});
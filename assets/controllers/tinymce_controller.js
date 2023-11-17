import { Controller } from '@hotwired/stimulus';
import tinymce from 'tinymce';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';
import 'tinymce/icons/default/icons';
import 'tinymce/plugins/image';
import 'tinymce/plugins/link';
// import 'tinymce/plugins/redo';
require('../../node_modules/tinymce/skins/ui/oxide-dark/skin.min.css')
// require('../../node_modules/tinymce/skins/ui/oxide/content.min.css')
// require('../../node_modules/tinymce/skins/content/dark/content.min.css')
/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {

  initialize() {

    let imageUploadHandler = (blobInfo, progress) => new Promise((resolve, reject) => {
      console.log('handler appelé');
      const formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());

      async function sendImageAsync(formData) {
        try {
          
          let response = await fetch(targetUrl, {
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
          });

          if (!response.ok) {
            throw new Error('error while making AJAX call: ' + response.status);
          } else {
            let data = await response.json();
            resolve(data.location);
            console.log(data.location);
          }
        } catch (error) {
          reject(error);
        }
      }

      sendImageAsync(formData);
    });

    // permet de paramétrer l'url cible AJAX si le guide existe ou pas
    let guideId = document.querySelector('#guideId').value || null
    let targetUrl
    
    if (guideId == null) {
      targetUrl = `${window.location.origin}/guide/new`
    }else{
      targetUrl = `${window.location.origin}/save-image-editor/${guideId}`
    }


    tinymce.init({
        skin : false,
        content_css: '/tiny.css',
        selector: 'textarea#guide_content',
        language_url: `${window.location.origin}/tinymce_langkit/fr_FR.js`,
        language: 'fr_FR',
        plugins: 'image link ',
        toolbar: "undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | outdent indent",
        // automatic_upload envoie les images en bdd 
        // /!automatic_upload  envoi les img en bdd à la soumission du form
        font_family_formats: 'Nunito Regular=Nunito-regular;Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
        automatic_uploads : true,
        a11y_advanced_options: true,
        images_upload_url: `${window.location.origin}/save-image-editor/${guideId}`,
        // image_uploadtab: true,
        image_advtab: true,
        convert_urls: false,
        file_picker_types : 'image',
        images_upload_handler : imageUploadHandler,
        // ce callback sert à l'upload de la photo en tant que blob
        // le blob sera envoyé dans un object formData en async "imageUploadHandler"
        file_picker_callback: function (cb, value, meta)
          {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            
            input.onchange = function () {
              var file = this.files[0];
                console.log(file);
              var reader = new FileReader();
              reader.onload = function () {
                /*
                  Note: Now we need to register the blob in TinyMCEs image blob
                  registry. In the next release this part hopefully won't be
                  necessary, as we are looking to handle it internally.
                */
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
        
                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
              };
              reader.readAsDataURL(file);
            };
            input.click();
          },
        
        setup: function (editor) {
          editor.on('change', function (e) {
              editor.save();
          })
        }
  });
  }

  disconnect(){
    tinymce.remove()
  }
}

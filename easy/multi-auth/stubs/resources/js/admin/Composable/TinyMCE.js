import {ref} from "vue";

export function initTinyMCE() {
    const key = ref('o5j6v9663pez7wo2kvizizkpqzqb8l5sb1pckhd3v5jl57wv');
    const initEditor = (height = 400) => {
      return {
          height: height,
          menubar: false,
          browser_spellcheck: true,
          image_title: true,
          automatic_uploads: true,
          file_picker_types: "image",
          file_picker_callback: function (cb, value, meta) {
              let input = document.createElement("input");
              input.setAttribute("type", "file");
              input.setAttribute("accept", "image/*");
              input.onchange = function () {
                  let file = this.files[0];
                  let reader = new FileReader();
                  reader.onload = function () {
                      let id = "blobid" + new Date().getTime();
                      let blobCache = tinymce.activeEditor.editorUpload.blobCache;
                      let base64 = reader.result.split(",")[1];
                      let blobInfo = blobCache.create(id, file, base64);
                      blobCache.add(blobInfo);
                      cb(blobInfo.blobUri(), { title: file.name });
                  };
                  reader.readAsDataURL(file);
              };
              input.click();
          },
          plugins: [
              "advlist autolink lists link image charmap print preview anchor",
              "searchreplace visualblocks code fullscreen",
              "insertdatetime media table paste code help wordcount",
          ],
          toolbar:
              "undo redo | formatselect | bold italic backcolor code| \
                 alignleft aligncenter alignright alignjustify | \
                 bullist numlist outdent indent | removeformat | image | table",
      }
    }

return { key, initEditor }
}

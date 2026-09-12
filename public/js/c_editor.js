document.addEventListener("DOMContentLoaded", function () {
  if (typeof CKEDITOR === "undefined") {
    return;
  }

  document
    .querySelectorAll("textarea.experiences")
    .forEach(function (textarea) {
      if (!textarea.id) {
        textarea.id = "editor_" + Math.random().toString(36).slice(2, 11);
      }

      if (!CKEDITOR.instances[textarea.id]) {
        CKEDITOR.replace(textarea.id, {
          language: "vi",
          versionCheck: false,
        });
      }
    });

  document.querySelector("form")?.addEventListener("submit", function () {
    Object.values(CKEDITOR.instances).forEach(function (editor) {
      editor.updateElement();
    });
  });
});

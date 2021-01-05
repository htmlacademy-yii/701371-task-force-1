
// NOTE: $(function () { ... } - upload only at the time of the request
$(function () {
  $("div#myId").dropzone({
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    url: '#',
    autoQueue: false,
    accept: function(file, done) {
      console.log(file);
    }
  });
});
window.addEventListener("load", () => {
    const loader = document.querySelector(".loader");
  
    loader.classList.add("loader--hidden");
  
    loader.addEventListener("transitionend", () => {
      document.body.removeChild(loader);
    });
  });

  function confirmDelete(courseId) {
    if (confirm("Are you sure you want to delete this course?")) {
        window.location.href = "my_courses.php?delete_course_id=" + courseId;
    }
}
let mainNav = document.getElementById("js-menu");
let navBarToggle = document.getElementById("js-navbar-toggle");

navBarToggle.addEventListener("click", function () {
   mainNav.classList.toggle("active");
});

// Get the modal
var modal = document.getElementById("applyModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

function openModal(jobId, jobPosition,companyName, jobType, jobLocation, jobDescription) {
   // Populate the modal with the job details
   document.getElementById("modalJobId").value = jobId;
   document.getElementById("jobPosition").innerText = jobPosition;
   document.getElementById("companyHome").innerText = companyName;
   document.getElementById("jobType").innerText = jobType;
   document.getElementById("jobLocation").innerText = jobLocation;
   document.getElementById("jobDescription").innerText = jobDescription;


   // Show the modal
   const modal = document.getElementById("jobDetailsModal");
   modal.style.display = "block";
   setTimeout(() => {
       modal.classList.add('show'); // Add class for transition
   }, 10); // Delay for the transition
}

function closeModal() {
   const modal = document.getElementById("jobDetailsModal");
   modal.classList.remove('show'); // Remove class for transition
   setTimeout(() => {
       modal.style.display = "none"; // Hide after transition
   }, 400); // Duration matches CSS transition
}


function toggleComments(jobPosition) {
   var commentsText = document.getElementById('comments-text-' + jobPosition);
   
   // Toggle between showing and hiding the comments text
   if (commentsText.style.display === "none" || commentsText.style.display === "") {
     commentsText.style.display = "block";
   } else {
     commentsText.style.display = "none";
   }
 }
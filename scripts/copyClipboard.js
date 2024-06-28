const copyButton = document.getElementById('copy-btn');
const textToCopy = document.getElementById('token').innerText;

//Check if the copy button and text to copy exist
if(copyButton && textToCopy) {
  copyButton.addEventListener('click', () => {
    navigator.clipboard.writeText(textToCopy)
      .then(() => {
        // (Optional) Feedback after successful copy
        copyButton.textContent = 'Copied!';
        setTimeout(() => {
          copyButton.textContent = 'Copy'; 
        }, 2000); // Reset after 2 seconds
      })
      .catch(err => {
        console.error('Failed to copy: ', err);
        // (Optional) Handle errors gracefully
      });
  });
}
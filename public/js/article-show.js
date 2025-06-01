document.addEventListener("DOMContentLoaded", function () {
    console.log("DOMContentLoaded event fired");
    const shareButton = document.querySelector('.action-btn-lg[title="Share"]');
    if (shareButton) {
        console.log("Share button found");
        shareButton.addEventListener("click", function () {
            console.log("Share button clicked");
            const title = document
                .querySelector(".article-title-hero")
                .textContent.trim();
            const url = window.location.href;

            if (navigator.share) {
                navigator
                    .share({
                        title: title,
                        url: url,
                    })
                    .then(() => {
                        console.log("Shared successfully");
                    })
                    .catch((error) => {
                        console.error("Error sharing:", error);
                    });
            } else {
                // Fallback: copy URL to clipboard
                navigator.clipboard
                    .writeText(url)
                    .then(() => {
                        alert("Article URL copied to clipboard");
                        console.log("URL copied to clipboard");
                    })
                    .catch(() => {
                        alert("Sharing not supported and failed to copy URL");
                        console.error("Failed to copy URL to clipboard");
                    });
            }
        });
    } else {
        console.log("Share button not found");
    }
});

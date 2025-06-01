document.addEventListener("DOMContentLoaded", function () {
    // Search functionality for icon click
    const searchIcon = document.getElementById("search-icon");
    const searchForm = document.getElementById("search-form");
    if (searchIcon && searchForm) {
        searchIcon.style.cursor = "pointer";
        searchIcon.addEventListener("click", function () {
            searchForm.submit();
        });
    }

    // Share button functionality
    const shareButtons = document.querySelectorAll(
        '.action-btn[title="Share"]'
    );
    shareButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const card = this.closest(".modern-card");
            if (!card) return;
            const title = card
                .querySelector(".article-title a")
                .textContent.trim();
            const url = card.querySelector(".article-title a").href;

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
    });

    // Load More functionality
    const loadMoreBtn = document.getElementById("load-more-btn");
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function () {
            const nextPageUrl = this.getAttribute("data-next-page");
            if (!nextPageUrl) return;

            this.disabled = true;
            this.querySelector(".btn-spinner").style.display = "inline-block";

            fetch(nextPageUrl, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => response.text())
                .then((html) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    const newArticles = doc.querySelectorAll(
                        "#articles-grid > div"
                    );
                    const articlesGrid =
                        document.getElementById("articles-grid");

                    newArticles.forEach((article) => {
                        articlesGrid.appendChild(article);
                    });
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.querySelector(".btn-spinner").style.display =
                        "none";
                })
                .catch(() => {
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.querySelector(".btn-spinner").style.display =
                        "none";
                });
        });
    }

    // Hover effects for cards
    const cards = document.querySelectorAll(".modern-card");
    cards.forEach((card) => {
        card.addEventListener("mousemove", function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left; // x position within the element
            const y = e.clientY - rect.top; // y position within the element

            // Calculate rotation based on mouse position
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            // Apply the rotation
            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
        });

        card.addEventListener("mouseleave", function () {
            // Reset the rotation when mouse leaves
            this.style.transform = "";
            setTimeout(() => {
                this.style.transition = "";
            }, 300);
        });

        card.addEventListener("mouseenter", function () {
            this.style.transition = "transform 0.1s ease";
        });
    });
});

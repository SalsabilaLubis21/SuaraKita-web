document.addEventListener("DOMContentLoaded", function () {
    const storyCards = document.querySelectorAll(".story-card");

    storyCards.forEach((card) => {
        card.addEventListener("mousemove", function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const xPercent = x / rect.width - 0.5;
            const yPercent = y / rect.height - 0.5;

            const rotateX = yPercent * -10;
            const rotateY = xPercent * 10;

            this.style.transform = `translateZ(30px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateZ(0) rotateX(0) rotateY(0)";
        });
    });

    const loadMoreBtn = document.getElementById("load-more-btn");
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function () {
            const nextPageUrl = this.getAttribute("data-next-page");
            if (!nextPageUrl) return;
            this.disabled = true;
            fetch(nextPageUrl, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => response.text())
                .then((html) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    const newStories = doc.querySelectorAll(".story-card");
                    const storiesGrid = document.querySelector(".stories-grid");
                    newStories.forEach((story) => {
                        storiesGrid.appendChild(story);
                    });
                    const newLoadMoreBtn = doc.getElementById("load-more-btn");
                    if (newLoadMoreBtn) {
                        loadMoreBtn.setAttribute(
                            "data-next-page",
                            newLoadMoreBtn.getAttribute("data-next-page")
                        );
                        loadMoreBtn.disabled = false;
                    } else {
                        loadMoreBtn.style.display = "none";
                    }

                    const newStoryCards = document.querySelectorAll(
                        ".story-card:not([data-tilt-applied])"
                    );
                    newStoryCards.forEach((card) => {
                        card.setAttribute("data-tilt-applied", "true");
                        card.addEventListener("mousemove", function (e) {
                            const rect = this.getBoundingClientRect();
                            const x = e.clientX - rect.left;
                            const y = e.clientY - rect.top;

                            const xPercent = x / rect.width - 0.5;
                            const yPercent = y / rect.height - 0.5;

                            const rotateX = yPercent * -10;
                            const rotateY = xPercent * 10;

                            this.style.transform = `translateZ(30px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                        });

                        card.addEventListener("mouseleave", function () {
                            this.style.transform =
                                "translateZ(0) rotateX(0) rotateY(0)";
                        });
                    });
                })
                .catch(() => {
                    loadMoreBtn.disabled = false;
                });
        });
    }

    const shareStoryBtn = document.getElementById("share-story-btn");
    if (shareStoryBtn) {
        shareStoryBtn.addEventListener("click", function (event) {
            event.preventDefault();

            if (window.isLoggedIn) {
                // If user is logged in, redirect directly to story creation page
                window.location.href = window.routes.storiesCreate;
                return;
            }

            // Custom modal container with glassmorphism
            const modalOverlay = document.createElement("div");
            modalOverlay.style.position = "fixed";
            modalOverlay.style.top = "0";
            modalOverlay.style.left = "0";
            modalOverlay.style.width = "100vw";
            modalOverlay.style.height = "100vh";
            modalOverlay.style.backgroundColor = "rgba(0, 0, 0, 0.7)";
            
            // --- PERBAIKAN: Tambahkan prefix -webkit-backdrop-filter untuk modalOverlay ---
            modalOverlay.style.webkitBackdropFilter = "blur(10px)"; 
            modalOverlay.style.backdropFilter = "blur(10px)"; 
            // ----------------------------------------------------------------------------------
            
            modalOverlay.style.display = "flex";
            modalOverlay.style.justifyContent = "center";
            modalOverlay.style.alignItems = "center";
            modalOverlay.style.zIndex = "10000";

            // Modal box with glassmorphism
            const modalBox = document.createElement("div");
            modalBox.style.background = "rgba(255, 255, 255, 0.1)";
            
            // --- PERBAIKAN: Tambahkan prefix -webkit-backdrop-filter untuk modalBox ---
            modalBox.style.webkitBackdropFilter = "blur(20px)"; 
            modalBox.style.backdropFilter = "blur(20px)";
            // -------------------------------------------------------------------------
            
            modalBox.style.borderRadius = "24px";
            modalBox.style.padding = "2.5rem 3rem";
            modalBox.style.maxWidth = "450px";
            modalBox.style.width = "90%";
            modalBox.style.boxShadow = "0 30px 60px rgba(0,0,0,0.3)";
            modalBox.style.textAlign = "center";
            modalBox.style.fontFamily = "'Inter', sans-serif";
            modalBox.style.border = "1px solid rgba(255, 255, 255, 0.2)";
            modalBox.style.transform = "translateY(20px)";
            modalBox.style.opacity = "0";
            modalBox.style.transition = "all 0.4s cubic-bezier(0.4, 0, 0.2, 1)";

            // Message paragraph
            const messageP = document.createElement("p");
            messageP.textContent =
                "Do you want to login? Press OK to login, Cancel to continue as anonymous.";
            messageP.style.fontSize = "1.2rem";
            messageP.style.marginBottom = "2rem";
            messageP.style.color = "#fff";
            messageP.style.lineHeight = "1.5";

            // Buttons container
            const btnContainer = document.createElement("div");
            btnContainer.style.display = "flex";
            btnContainer.style.justifyContent = "center";
            btnContainer.style.gap = "1rem";
            btnContainer.style.flexWrap = "wrap";

            // Login button with gradient
            const btnLogin = document.createElement("button");
            btnLogin.textContent = "Login";
            btnLogin.style.background = "rgba(255, 255, 255, 0.1)";
            
            // --- PERBAIKAN: Tambahkan prefix -webkit-backdrop-filter untuk btnLogin ---
            btnLogin.style.webkitBackdropFilter = "blur(10px)"; 
            btnLogin.style.backdropFilter = "blur(10px)"; 
            // -----------------------------------------------------------------------------
            
            btnLogin.style.border = "1px solid rgba(255, 255, 255, 0.2)";
            btnLogin.style.color = "white";
            btnLogin.style.padding = "0.8rem 2rem";
            btnLogin.style.borderRadius = "50px";
            btnLogin.style.fontWeight = "600";
            btnLogin.style.cursor = "pointer";
            btnLogin.style.fontSize = "1rem";
            btnLogin.style.transition = "all 0.3s ease";
            btnLogin.style.position = "relative";
            btnLogin.style.overflow = "hidden";

            btnLogin.addEventListener("mouseenter", () => {
                btnLogin.style.background =
                    "linear-gradient(135deg, #667eea 0%, #764ba2 100%)";
                btnLogin.style.boxShadow =
                    "0 10px 30px rgba(102, 126, 234, 0.4)";
                btnLogin.style.transform = "translateY(-3px)";
            });

            btnLogin.addEventListener("mouseleave", () => {
                btnLogin.style.background = "rgba(255, 255, 255, 0.1)";
                btnLogin.style.boxShadow = "none";
                btnLogin.style.transform = "translateY(0)";
            });

            const btnAnonymous = document.createElement("button");
            btnAnonymous.textContent = "Continue as Anonymous";
            btnAnonymous.style.background = "rgba(255, 255, 255, 0.05)";
            
            // --- PERBAIKAN: Tambahkan prefix -webkit-backdrop-filter untuk btnAnonymous ---
            btnAnonymous.style.webkitBackdropFilter = "blur(10px)"; 
            btnAnonymous.style.backdropFilter = "blur(10px)"; 
            // ---------------------------------------------------------------------------------
            
            btnAnonymous.style.border = "1px solid rgba(255, 255, 255, 0.1)";
            btnAnonymous.style.color = "rgba(255, 255, 255, 0.8)";
            btnAnonymous.style.padding = "0.8rem 2rem";
            btnAnonymous.style.borderRadius = "50px";
            btnAnonymous.style.fontWeight = "600";
            btnAnonymous.style.cursor = "pointer";
            btnAnonymous.style.fontSize = "1rem";
            btnAnonymous.style.transition = "all 0.3s ease";

            btnAnonymous.addEventListener("mouseenter", () => {
                btnAnonymous.style.background = "rgba(255, 255, 255, 0.1)";
                btnAnonymous.style.transform = "translateY(-3px)";
            });

            btnAnonymous.addEventListener("mouseleave", () => {
                btnAnonymous.style.background = "rgba(255, 255, 255, 0.05)";
                btnAnonymous.style.transform = "translateY(0)";
            });

            btnLogin.addEventListener("click", () => {
                window.location.href =
                    window.routes.login +
                    "?role=user&redirect=" +
                    encodeURIComponent("/stories/create");
            });

            btnAnonymous.addEventListener("click", () => {
                window.location.href = window.routes.storiesCreate;
            });

            btnContainer.appendChild(btnLogin);
            btnContainer.appendChild(btnAnonymous);
            modalBox.appendChild(messageP);
            modalBox.appendChild(btnContainer);
            modalOverlay.appendChild(modalBox);
            document.body.appendChild(modalOverlay);

            setTimeout(() => {
                modalBox.style.transform = "translateY(0)";
                modalBox.style.opacity = "1";
            }, 10);

            modalOverlay.addEventListener("click", (e) => {
                if (e.target === modalOverlay) {
                    modalBox.style.transform = "translateY(20px)";
                    modalBox.style.opacity = "0";

                    setTimeout(() => {
                        document.body.removeChild(modalOverlay);
                    }, 400);
                }
            });
        });
    }
});
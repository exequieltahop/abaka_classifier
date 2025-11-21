let deferredPrompt = null;

window.addEventListener("beforeinstallprompt", (e) => {
    e.preventDefault();
    deferredPrompt = e;

    const installButtons = document.querySelectorAll(".install-pwa");
    installButtons.forEach(btn => btn.classList.remove("hidden"));
});

window.addEventListener("DOMContentLoaded", () => {
    const installButtons = document.querySelectorAll(".install-pwa");

    installButtons.forEach(button => {
        button.addEventListener("click", async () => {

            if (!deferredPrompt) {
                alert("PWA not ready to install.");
                return;
            }

            deferredPrompt.prompt();
            const choice = await deferredPrompt.userChoice;

            console.log("PWA Install choice:", choice.outcome);

            deferredPrompt = null;

            installButtons.forEach(btn => btn.classList.add("hidden"));
        });
    });
});

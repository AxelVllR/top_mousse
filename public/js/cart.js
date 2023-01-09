const selectElements = document.querySelectorAll("[data-open]");
const isVisible = "is-visible";
for (const el of selectElements) {
    el.addEventListener("change", function () {
        const btnId = `amount${this.dataset.open}`;
        console.log(btnId)
        document.getElementById(btnId).classList.add(isVisible);
    });
}
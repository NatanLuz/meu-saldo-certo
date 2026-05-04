import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    Alpine.store("theme", {
        mode: null,

        init() {
            try {
                const stored = localStorage.getItem("theme");
                if (stored === "dark" || stored === "light") {
                    this.mode = stored;
                } else if (
                    window.matchMedia &&
                    window.matchMedia("(prefers-color-scheme: dark)").matches
                ) {
                    this.mode = "dark";
                } else {
                    this.mode = "light";
                }

                if (this.mode === "dark") {
                    document.documentElement.classList.add("dark");
                } else {
                    document.documentElement.classList.remove("dark");
                }
            } catch (e) {
                this.mode = "light";
            }
        },

        toggle() {
            try {
                this.mode = this.mode === "dark" ? "light" : "dark";
                if (this.mode === "dark")
                    document.documentElement.classList.add("dark");
                else document.documentElement.classList.remove("dark");
                localStorage.setItem("theme", this.mode);
                window.dispatchEvent(new CustomEvent("theme-changed"));
            } catch (e) {
                // ignore
            }
        },

        isDark() {
            return this.mode === "dark";
        },
    });
});

Alpine.start();

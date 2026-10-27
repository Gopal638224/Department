/* =====================================================
   CSE DEPARTMENT
   ADVANCED STUDENT REGISTRATION
   INTERACTIVE JAVASCRIPT
===================================================== */


/* =====================================================
   GET HTML ELEMENTS
===================================================== */

const card = document.getElementById("registerCard");

const password = document.getElementById("password");

const confirmPassword =
    document.getElementById("confirm_password");

const strengthFill =
    document.getElementById("strengthFill");

const strengthText =
    document.getElementById("strengthText");

const matchText =
    document.getElementById("matchText");

const form =
    document.getElementById("registrationForm");


/* =====================================================
   1. 3D CARD MOUSE EFFECT
===================================================== */

if (
    card &&
    window.matchMedia("(min-width: 901px)").matches
) {

    card.addEventListener("mousemove", function (e) {

        const rect =
            card.getBoundingClientRect();

        const x =
            e.clientX - rect.left;

        const y =
            e.clientY - rect.top;

        const rotateY =
            ((x / rect.width) - 0.5) * 8;

        const rotateX =
            ((y / rect.height) - 0.5) * -8;

        card.style.transform =
            `
            perspective(1200px)
            rotateX(${rotateX}deg)
            rotateY(${rotateY}deg)
            translateY(-3px)
            scale(1.01)
            `;

    });


    card.addEventListener("mouseleave", function () {

        card.style.transform =
            `
            perspective(1200px)
            rotateX(0deg)
            rotateY(0deg)
            translateY(0)
            scale(1)
            `;

    });

}


/* =====================================================
   2. PASSWORD SHOW / HIDE
===================================================== */

document
    .querySelectorAll(".eye-btn")
    .forEach(function (button) {

        button.addEventListener("click", function () {

            const target =
                button.dataset.target;

            const input =
                document.getElementById(target);

            if (!input) {
                return;
            }

            const visible =
                input.type === "text";


            if (visible) {

                input.type = "password";

                button.textContent = "Show";

                button.setAttribute(
                    "aria-label",
                    "Show password"
                );

            } else {

                input.type = "text";

                button.textContent = "Hide";

                button.setAttribute(
                    "aria-label",
                    "Hide password"
                );

            }

        });

    });


/* =====================================================
   3. PASSWORD STRENGTH FUNCTION
===================================================== */

function passwordStrength(value) {

    let score = 0;


    /* Minimum 6 characters */

    if (value.length >= 6) {
        score++;
    }


    /* 10 or more characters */

    if (value.length >= 10) {
        score++;
    }


    /* Capital letter */

    if (/[A-Z]/.test(value)) {
        score++;
    }


    /* Number */

    if (/[0-9]/.test(value)) {
        score++;
    }


    /* Special character */

    if (/[^A-Za-z0-9]/.test(value)) {
        score++;
    }


    return score;
}


/* =====================================================
   4. PASSWORD STRENGTH DISPLAY
===================================================== */

if (password) {

    password.addEventListener(
        "input",
        function () {

            const value =
                password.value;

            const score =
                passwordStrength(value);


            const widths = [

                "0%",

                "20%",

                "40%",

                "60%",

                "80%",

                "100%"

            ];


            const labels = [

                "Password strength",

                "Very weak",

                "Weak",

                "Good",

                "Strong",

                "Excellent"

            ];


            if (strengthFill) {

                strengthFill.style.width =
                    widths[score];

            }


            if (strengthText) {

                strengthText.textContent =
                    labels[score];

            }

        }
    );

}


/* =====================================================
   5. PASSWORD MATCH CHECK
===================================================== */

function checkMatch() {

    if (!password || !confirmPassword) {
        return;
    }


    if (confirmPassword.value === "") {

        if (matchText) {

            matchText.textContent = "";

        }

        confirmPassword.classList.remove(
            "input-success"
        );

        confirmPassword.classList.remove(
            "input-error"
        );

        return;
    }


    if (
        password.value ===
        confirmPassword.value
    ) {

        if (matchText) {

            matchText.textContent =
                "✓ Passwords match";

            matchText.classList.remove(
                "password-error"
            );

            matchText.classList.add(
                "password-success"
            );

        }


        confirmPassword.classList.remove(
            "input-error"
        );

        confirmPassword.classList.add(
            "input-success"
        );

    } else {

        if (matchText) {

            matchText.textContent =
                "✕ Passwords do not match";

            matchText.classList.remove(
                "password-success"
            );

            matchText.classList.add(
                "password-error"
            );

        }


        confirmPassword.classList.remove(
            "input-success"
        );

        confirmPassword.classList.add(
            "input-error"
        );

    }

}


/* =====================================================
   6. PASSWORD MATCH EVENTS
===================================================== */

if (password) {

    password.addEventListener(
        "input",
        checkMatch
    );

}

if (confirmPassword) {

    confirmPassword.addEventListener(
        "input",
        checkMatch
    );

}


/* =====================================================
   7. FORM VALIDATION
===================================================== */

if (form) {

    form.addEventListener(
        "submit",
        function (e) {

            if (!password || !confirmPassword) {
                return;
            }


            /* Password mismatch */

            if (
                password.value !==
                confirmPassword.value
            ) {

                e.preventDefault();


                if (matchText) {

                    matchText.textContent =
                        "✕ Passwords do not match";

                    matchText.classList.add(
                        "password-error"
                    );

                }


                confirmPassword.focus();

                return;

            }


            /* Minimum password */

            if (password.value.length < 6) {

                e.preventDefault();

                alert(
                    "Password must contain at least 6 characters."
                );

                password.focus();

                return;

            }

        }
    );

}


/* =====================================================
   8. PREVENT OLD FORM VALUES
===================================================== */

window.addEventListener(
    "pageshow",
    function () {

        /*
         * This clears the registration form when
         * the page is loaded from browser history.
         */

        if (form) {

            form.reset();

        }


        if (strengthFill) {

            strengthFill.style.width =
                "0%";

        }


        if (strengthText) {

            strengthText.textContent =
                "Password strength";

        }


        if (matchText) {

            matchText.textContent =
                "";

        }

    }
);


/* =====================================================
   9. INPUT ANIMATION
===================================================== */

document
    .querySelectorAll(
        "#registrationForm input"
    )
    .forEach(function (input) {

        input.addEventListener(
            "focus",
            function () {

                input.parentElement
                    ?.classList
                    .add("input-focused");

            }
        );


        input.addEventListener(
            "blur",
            function () {

                input.parentElement
                    ?.classList
                    .remove("input-focused");

            }
        );

    });


/* =====================================================
   10. 3D BUTTON EFFECT
===================================================== */

const registerButton =
    document.querySelector(
        ".register-btn"
    );


if (registerButton) {

    registerButton.addEventListener(
        "mousemove",
        function (e) {

            const rect =
                registerButton.getBoundingClientRect();

            const x =
                e.clientX - rect.left;

            const y =
                e.clientY - rect.top;

            const rotateY =
                ((x / rect.width) - 0.5) * 6;

            const rotateX =
                ((y / rect.height) - 0.5) * -6;

            registerButton.style.transform =
                `
                perspective(500px)
                rotateX(${rotateX}deg)
                rotateY(${rotateY}deg)
                translateY(-3px)
                `;

        }
    );


    registerButton.addEventListener(
        "mouseleave",
        function () {

            registerButton.style.transform =
                "translateY(0)";

        }
    );

}


/* =====================================================
   11. PAGE LOAD ANIMATION
===================================================== */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const elements =
            document.querySelectorAll(
                ".register-card"
            );


        elements.forEach(function (element) {

            element.style.opacity = "0";

            element.style.transform =
                "translateY(30px)";


            setTimeout(function () {

                element.style.transition =
                    "opacity 0.8s ease, transform 0.8s ease";

                element.style.opacity = "1";

                element.style.transform =
                    "translateY(0)";

            }, 100);

        });

    }
);
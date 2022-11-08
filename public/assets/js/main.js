function copyToClipboard(textToCopy) {
    // navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
        // navigator clipboard api method'
        return navigator.clipboard.writeText(textToCopy);
    }

    // text area method
    let textArea = document.createElement("textarea");
    textArea.value = textToCopy;
    // make the textarea out of viewport
    textArea.style.position = "fixed";
    textArea.style.left = "-999999px";
    textArea.style.top = "-999999px";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    return new Promise((res, rej) => {
        // here the magic happens
        document.execCommand("copy") ? res() : rej();
        textArea.remove();
    });
}

function showCopyToolTip(element) {
    $(element)
        .popup({
            content: "Copy to clipboard",
            closable: false,
            onRemove: (el) => {
                showCopyToolTip(el);
            },
        })
        .on("click", (e) => {
            $(e.target)
                .popup({
                    content: "Copied!",
                    closable: true,
                    onRemove: (el) => {
                        showCopyToolTip(el);
                    },
                })
                .popup("show");

            return false;
        });
}

function addFormField(fieldId) {
    var template = document.getElementById("template-" + fieldId);
    var copy = template.cloneNode(true);
    copy.innerHTML = copy.innerHTML.replaceAll(
        "**i**",
        window.formFieldIncrements[fieldId]
    );

    template.parentNode.insertBefore(copy.content, template);
    window.formFieldIncrements[fieldId]++;
}

function revealFormField(templateId) {
    var template = document.getElementById(templateId);
    template.parentNode.insertBefore(template.content, template);
    template.remove();
}
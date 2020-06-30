export default class TextAreaExtended {
    constructor(element, options = {}) {
        this.element = element;

        if(options.tabs == true) {
            this.enableTabs();
        }
    }

    getCaretPosition() {
        return this.element.selectionStart;
    }

    setCaretPosition(position) {
        this.element.selectionStart = position;
        this.element.selectionEnd = position;
        this.element.focus();
    }

    hasSelection() {
        return this.element.selectionStart != this.element.selectionEnd;
    }

    getSelectedText() {
        return this.element.value.substring(this.element.selectionStart, this.element.selectionEnd);
    }

    setSelection(start, end) {
        this.element.selectionStart = start;
        this.element.selectionEnd = end;
        this.element.focus();
    }

    enableTabs() {
        this.element.onkeydown = (event) => {
            if (event.keyCode == 9) {
                let newCaretPosition = this.getCaretPosition() + "\t".length;
                this.element.value = this.element.value.substring(0, this.getCaretPosition()) + "\t" + this.element.value.substring(this.getCaretPosition(), this.element.value.length);
                this.setCaretPosition(newCaretPosition);
                return false;
            }
        }
    }
}

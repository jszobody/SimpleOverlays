export default class TextAreaExtended {
    constructor(element, options = {}) {
        this.element = element;

        if(options.tabs == true) {
            this.enableTabs();
        }

        this.onChange = options.onChange || function() {};
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

    replaceSelectedText(replacement) {
        if(!this.hasSelection()) return;

        let selectionStart = this.element.selectionStart;

        this.element.value =
            this.element.value.substring(0, this.element.selectionStart)
            + replacement
            + this.element.value.substring(this.element.selectionEnd, this.element.value.length);

        this.setSelection(selectionStart, selectionStart + replacement.length);
        this.onChange.call();
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

    wrapSelection(wrap, toggle = true) {
        let selection = this.getSelectedText();
        let replacement = '';

        if(toggle && _.startsWith(selection, wrap) && _.endsWith(selection, wrap)) {
            replacement = selection.substr(wrap.length, selection.length - (wrap.length * 2));
        } else {
            replacement = wrap + selection + wrap;
        }

        this.replaceSelectedText(replacement);
    }

    formatVerseNumbers() {
        this.replaceSelectedText(this.getSelectedText().replace(/(\d+)/g, ' [$1] '));
    }

    removeWhitespace() {
        this.replaceSelectedText(this.getSelectedText().replace(/[\n\t]/g, " "));
    }
}

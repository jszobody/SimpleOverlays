export default class Scroller {
    constructor(container, options = {}) {
        this.container = container;
        this.direction = options.direction || "vertical";
    }

    scrollIntoView(element) {
        if(this.elementStartPosition(element) >= this.containerStartPosition() && this.elementEndPosition(element) <= this.containerEndPosition()) {
            // Target is already in view
            return
        } else {
            this.scrollContainerTo(this.getNewPosition(element));
        }
    }

    containerStartPosition() {
        return this.direction == "vertical" ? this.container.scrollTop : this.container.scrollLeft;
    }

    containerEndPosition() {
        return this.containerStartPosition() + this.containerSize();
    }

    containerSize() {
        return this.direction == "vertical" ? this.container.offsetHeight : this.container.offsetWidth;
    }

    elementStartPosition(element) {
        return this.direction == "vertical" ? element.offsetTop : element.offsetLeft;
    }

    elementEndPosition(element) {
        return this.elementStartPosition(element) + this.elementSize(element);
    }

    elementSize(element) {
        return this.direction == "vertical" ? element.offsetHeight : element.offsetWidth;
    }

    getNewPosition(element)
    {
        return this.elementStartPosition(element) < this.containerStartPosition()
            ? this.elementStartPosition(element)
            : this.elementStartPosition(element) - this.containerSize() + this.elementSize(element);
    }

    scrollContainerTo(position) {
        if(this.direction == "vertical") {
            this.container.scrollTop = position;
        } else {
            this.container.scrollLeft = position;
        }
    }
}

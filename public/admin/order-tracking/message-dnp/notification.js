const DEFAULT_NOTIFICATION_OPTIONS = {
  position: 'top-right',
  type: "default",
  // progressbar: "default",
  autoClose: 5000,
  canClose: true,
  showProgress: true,
  pauseOnHover: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  pauseOnFocusLoss: true,
  onClose: () => {},
};


class NOTIFY {
  hb_notificationElement;
  hb_autoCloseInterval;
  hb_progressInterval;
  hb_removeBinded;
  hb_timeVisible = 0;
  hb_autoClose;
  hb_isPaused = false;
  hb_unpause;
  hb_pause;
  hb_visibilityChnage;
  hb_shouldUnPause;

  constructor(options) {
    this.hb_notificationElement = document.createElement('div');
    this.hb_notificationElement.classList.add('hb-notification');

    requestAnimationFrame(() =>
      this.hb_notificationElement.classList.add('show')
    );

    this.hb_removeBinded = this.remove.bind(this);

    this.hb_unpause = () => (this.hb_isPaused = false);
    this.hb_pause = () => (this.hb_isPaused = true);

    this.hb_visibilityChnage = () => {
      this.hb_shouldUnPause = document.visibilityState === 'visible';
    };

    this.update({
      ...DEFAULT_NOTIFICATION_OPTIONS,
      ...options
    });
  }

  set autoClose(value) {
    this.hb_autoClose = value;
    this.hb_timeVisible = 0;
    if (value === false) return;

    let lastTime;
    const func = (time) => {
      if (this.hb_shouldUnPause) {
        lastTime = null;
        this.hb_shouldUnPause = false;
      }

      if (lastTime == null) {
        lastTime = time;
        this.hb_autoCloseInterval = requestAnimationFrame(func);
        return;
      }

      if (!this.hb_isPaused) {
        this.hb_timeVisible += time - lastTime;

        if (this.hb_timeVisible >= this.hb_autoClose) {
          this.remove();
          return;
        }
      }

      lastTime = time;
      this.hb_autoCloseInterval = requestAnimationFrame(func);
    };

    this.hb_autoCloseInterval = requestAnimationFrame(func);
  }

  set position(value) {
    const currentContainer = this.hb_notificationElement.parentElement;
    const selector = `.hb-notification-container[data-position='${value}']`;
    const container =
      document.querySelector(selector) || createContainer(value);

    container.append(this.hb_notificationElement);

    if (currentContainer === null || currentContainer.hasChildNodes()) return;

    currentContainer.remove();
  }

  set text(message) {
    this.hb_notificationElement.innerHTML = message;
  }

  set canClose(value) {
    this.hb_notificationElement.classList.toggle('can-close', value);
    if (value) {
      this.hb_notificationElement.addEventListener('click', () => {
        cancelAnimationFrame(this.hb_autoCloseInterval);
        this.remove();
      });
    } else {
      this.hb_notificationElement.removeEventListener(
        'click',
        this.hb_removeBinded
      );
    }
  }

  set style(styles) {
    Object.entries(styles).forEach(([key, value]) => {
      this.hb_notificationElement.style[key] = value;
    });
  }

  set showProgress(value) {
    this.hb_notificationElement.classList.toggle('hb_progress', value);
    this.hb_notificationElement.style.setProperty('--progress', 1);

    if (value) {
      let lastTime;

      const func = (time) => {
        if (lastTime == null) {
          lastTime = time;
          this.hb_progressInterval = requestAnimationFrame(func);
          return;
        }

        if (!this.hb_isPaused) {
          this.hb_notificationElement.style.setProperty(
            '--progress',
            1 - this.hb_timeVisible / this.hb_autoClose
          );
        }

        lastTime = time;
        this.hb_progressInterval = requestAnimationFrame(func);
      };

      this.hb_progressInterval = requestAnimationFrame(func);
    }
  }

  set pauseOnHover(value) {
    this.hb_notificationElement.classList.toggle('can-close', value);
    if (value) {
      this.hb_notificationElement.addEventListener('mouseover', this.hb_pause);
      this.hb_notificationElement.addEventListener('mouseleave', this.hb_unpause);
    } else {
      this.hb_notificationElement.removeEventListener('mouseover', this.hb_pause);
      this.hb_notificationElement.removeEventListener(
        'mouseleave',
        this.hb_unpause
      );
    }
  }

  set pauseOnFocusLoss(value) {
    this.hb_notificationElement.classList.toggle('can-close', value);
    if (value) {
      document.addEventListener('visibilitychange', this.hb_visibilityChnage);
    } else {
      document.removeEventListener('visibilitychange', this.hb_visibilityChnage);
    }
  }

  // custom functions start
  set type(value) {
    const notificationBox = this.hb_notificationElement;
    notificationBox.setAttribute(`data-notification-type`, value)
    notificationBox.setAttribute(`data-progressbar`, value)
  }
  // custom functions end

  update(options) {
    if (typeof options === 'object') {
      Object.entries(options).forEach(([key, value]) => {
        this[key] = value;
      });
    } else {
      console.error('options must be type of object');
      return;
    }
  }

  remove() {
    cancelAnimationFrame(this.hb_autoCloseInterval);
    cancelAnimationFrame(this.hb_progressInterval);

    const container = this.hb_notificationElement.parentElement;

    this.hb_notificationElement.classList.remove('show');

    this.hb_notificationElement.addEventListener('transitionend', () => {
      this.hb_notificationElement.remove();

      if (container.hasChildNodes()) return;

      container.remove();
    });

    this.onClose();
  }
}

function createContainer(position) {
  const container = document.createElement('div');
  container.classList.add('hb-notification-container');

  container.dataset.position = position;

  document.body.append(container);

  return container;
}
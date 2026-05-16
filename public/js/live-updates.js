/**
 * SmartCity PH — Live Updates (AJAX polling, no WebSockets)
 *
 * Polls JSON endpoints and patches only the parts of the DOM that changed.
 * Honors prefers-reduced-motion and stops polling when the tab is hidden.
 */
(function () {
  'use strict';

  var BASE = (window.SCPH_BASE || '').replace(/\/+$/, '');
  var STATUS_ORDER = ['pending', 'reviewing', 'in_progress', 'resolved'];
  var STEP_ICONS   = ['fa-paper-plane', 'fa-eye', 'fa-gear', 'fa-circle-check'];

  var LiveUpdates = {
    INTERVAL: 15000,
    CONTENT_INTERVAL: 30000,

    lastStatus: null,
    lastNewsKey: '',
    lastServiceKey: '',
    timers: [],
    primed: false,

    api: function (path) { return BASE + '/api/' + path.replace(/^\/+/, ''); },

    watchReport: function (reference) {
      if (! reference) return;
      var self = this;

      var poll = function () {
        fetch(self.api('report-status/' + encodeURIComponent(reference)), { credentials: 'same-origin' })
          .then(function (res) { return res.ok ? res.json() : null; })
          .then(function (data) {
            if (! data || data.error) return;

            // First successful poll establishes the baseline silently.
            if (! self.primed) {
              self.lastStatus = data.status;
              self.primed = true;
              return;
            }

            if (self.lastStatus !== data.status) {
              self.lastStatus = data.status;
              self.updateProgressBar(data.status);
              self.updateStatusBadge(data.status);
              self.updateAdminNotes(data.admin_notes);
              self.updateLastUpdated(data.updated_at);
              self.showUpdateNotification('Report status updated to ' + self.label(data.status));
            } else {
              // status same — still refresh notes/timestamp quietly if they changed
              self.updateAdminNotes(data.admin_notes, true);
              self.updateLastUpdated(data.updated_at);
            }
          })
          .catch(function () { /* silent */ });
      };

      poll();
      this.timers.push(setInterval(poll, this.INTERVAL));
    },

    label: function (status) {
      var map = { pending: 'Pending', reviewing: 'Reviewing', in_progress: 'In progress', resolved: 'Resolved', rejected: 'Rejected' };
      return map[status] || status;
    },

    updateProgressBar: function (status) {
      var steps = document.querySelectorAll('.timeline .timeline-step');
      if (! steps.length) return;
      var activeIndex = STATUS_ORDER.indexOf(status);
      steps.forEach(function (el, i) {
        el.classList.remove('done', 'active');
        if (activeIndex === -1) return; // rejected → no active step
        if (i < activeIndex) el.classList.add('done');
        else if (i === activeIndex) el.classList.add('active');
        var icon = el.querySelector('.dot i');
        if (icon && STEP_ICONS[i]) {
          icon.className = 'fa-solid ' + STEP_ICONS[i];
        }
      });
    },

    updateStatusBadge: function (status) {
      // Match existing server-rendered format: lowercase text, .badge-{status} class.
      document.querySelectorAll('[data-live-status-badge]').forEach(function (el) {
        el.className = 'badge badge-' + status;
        el.textContent = status;
      });
    },

    updateAdminNotes: function (notes, quiet) {
      var box = document.querySelector('[data-live-notes]');
      if (! box) return;
      var body = box.querySelector('[data-live-notes-body]');
      var current = body ? body.textContent.trim() : '';
      var incoming = (notes || '').trim();

      if (incoming) {
        if (body) body.textContent = incoming;
        box.style.display = '';
        if (! quiet && current !== incoming) {
          box.classList.add('is-flashing');
          setTimeout(function () { box.classList.remove('is-flashing'); }, 2000);
        }
      }
    },

    updateLastUpdated: function (datetime) {
      if (! datetime) return;
      var nodes = document.querySelectorAll('[data-live-updated]');
      if (! nodes.length) return;
      // Server format: "YYYY-MM-DD HH:MM:SS" — convert to ISO so Safari/iOS parse it.
      var iso = String(datetime).replace(' ', 'T');
      var d = new Date(iso);
      if (isNaN(d.getTime())) return;
      var formatted = d.toLocaleString('en-PH', {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: 'numeric', minute: '2-digit', hour12: true,
      });
      nodes.forEach(function (n) { n.textContent = formatted; });
    },

    watchContent: function () {
      var self = this;
      var poll = function () {
        fetch(self.api('latest-news'), { credentials: 'same-origin' })
          .then(function (res) { return res.ok ? res.json() : null; })
          .then(function (rows) {
            if (! Array.isArray(rows)) return;
            var key = rows.map(function (n) { return n.id; }).join(',');
            if (self.lastNewsKey && key && self.lastNewsKey !== key) {
              self.showUpdateNotification('New news available');
            }
            self.lastNewsKey = key;
          })
          .catch(function () { /* silent */ });
      };
      poll();
      this.timers.push(setInterval(poll, this.CONTENT_INTERVAL));
    },

    showUpdateNotification: function (message) {
      var existing = document.querySelector('.live-update-toast');
      if (existing) existing.remove();

      var toast = document.createElement('div');
      toast.className = 'live-update-toast';
      toast.setAttribute('role', 'status');
      toast.setAttribute('aria-live', 'polite');

      var dot = document.createElement('span'); dot.className = 'live-dot'; toast.appendChild(dot);
      var msg = document.createElement('span'); msg.className = 'live-msg'; msg.textContent = message; toast.appendChild(msg);

      var refresh = document.createElement('button');
      refresh.type = 'button'; refresh.className = 'toast-refresh-btn'; refresh.textContent = 'Refresh';
      refresh.addEventListener('click', function () { location.reload(); });
      toast.appendChild(refresh);

      var close = document.createElement('button');
      close.type = 'button'; close.className = 'toast-close';
      close.setAttribute('aria-label', 'Dismiss');
      close.innerHTML = '&times;';
      close.addEventListener('click', function () { toast.remove(); });
      toast.appendChild(close);

      document.body.appendChild(toast);
      setTimeout(function () { if (toast.parentNode) toast.remove(); }, 8000);
    },

    stop: function () {
      this.timers.forEach(function (t) { clearInterval(t); });
      this.timers = [];
    },

    start: function () {
      var path = window.location.pathname;
      var params = new URLSearchParams(window.location.search);

      if (/\/track(\/|$|\?)/.test(path) && params.get('ref')) {
        this.watchReport(params.get('ref'));
      }

      // Trigger lightweight content polling on home / news / services
      if (/\/(news|services)(\/|$)/.test(path) || /\/(public)?\/?$/.test(path)) {
        this.watchContent();
      }
    },
  };

  window.LiveUpdates = LiveUpdates;

  function init() { LiveUpdates.start(); }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      LiveUpdates.stop();
    } else if (! LiveUpdates.timers.length) {
      // Re-prime when the tab returns so we don't fire a stale toast.
      LiveUpdates.primed = false;
      LiveUpdates.start();
    }
  });
})();

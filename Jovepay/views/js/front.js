/**
 * Move JOVEpay logo | title | coin-stack markup into the payment option label.
 * Core themes escape call_to_action_text, so HTML is shipped via additionalInformation.
 */
(function () {
  var MODULE_NAME = 'Jovepay';

  function applyJovepayPaymentLabels() {
    var inputs = document.querySelectorAll(
      'input[data-module-name="' + MODULE_NAME + '"]'
    );

    for (var i = 0; i < inputs.length; i++) {
      var input = inputs[i];
      var label = document.querySelector('label[for="' + input.id + '"]');
      if (!label || label.querySelector('.jpps-payment-method-label')) {
        continue;
      }

      var additional = document.getElementById(
        input.id + '-additional-information'
      );
      if (!additional) {
        continue;
      }

      var sourceLabel = additional.querySelector('.jpps-payment-method-label');
      if (!sourceLabel) {
        continue;
      }

      label.innerHTML = '';
      label.appendChild(sourceLabel);

      var sourceWrap = additional.querySelector('.jpps-label-source');
      if (sourceWrap) {
        sourceWrap.parentNode.removeChild(sourceWrap);
      }

      if (!additional.querySelector('.jpps-payment-infos')) {
        additional.classList.add('ps-hidden');
        additional.setAttribute('hidden', 'hidden');
      }
    }
  }

  function onReady(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  onReady(applyJovepayPaymentLabels);

  if (typeof prestashop !== 'undefined' && typeof prestashop.on === 'function') {
    prestashop.on('updatedPaymentForm', applyJovepayPaymentLabels);
    prestashop.on('changedCheckoutStep', applyJovepayPaymentLabels);
  }
})();

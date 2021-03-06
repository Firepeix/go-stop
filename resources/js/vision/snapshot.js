const fs = require('fs');
module.exports = {
  snapCameras (browser) {
    let currentSnaps = 0;
    const id = browser.options.test_settings.cameraId;
    const cameraSessionId = browser.options.test_settings.cameraSessionId;
    const maxSnaps = browser.options.test_settings.frames;
    const secondsPerFrame = 1050

    browser
      .url('http://localhost/web/snapshot/' + id)
      .waitForElementVisible('.rmp-button', 10 * 1000)
      .click('.rmp-button');

    setTimeout(function () {
      const interval = setInterval(function () {
        browser.execute(function () {
          return snap();
        },[], function (response) {
          storeImage(cameraSessionId, currentSnaps, response.value)
        })
        currentSnaps++;
        if (currentSnaps > maxSnaps) {
          clearInterval(interval)
        }
      }, secondsPerFrame)
    }, 6 * 1000)

    browser.pause((maxSnaps + 7) * secondsPerFrame).end();
  }
};

function storeImage (sessionCameraId, index, value) {
  console.log(index);
  fs.writeFileSync(`./storage/app/raw-images/${sessionCameraId}/${index}.txt`, value);
}

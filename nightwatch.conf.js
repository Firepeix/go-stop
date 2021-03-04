const chrome = require("chromedriver");
module.exports = {
  // An array of folders (excluding subfolders) where your tests are located;
  // if this is not specified, the test source must be passed as the second argument to the test runner.
  src_folders: ["resources"],

  webdriver: {
    start_process: true,
    port: 9515,
    server_path: chrome.path,
    cli_args: [
    ]
  },

  test_settings: {
    default: {
      launch_url: 'https://nightwatchjs.org',
      desiredCapabilities : {
        browserName : 'chrome',
        chromeOptions : {
          "args" : [
            "--window-size=1325x744",
            "--disable-gpu",
            "--headless",
            "--no-sandbox",
            "--ignore-certificate-errors"],
          "binary": "C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe"
        },
        "javascriptEnabled": true,
      }
    }
  }
};

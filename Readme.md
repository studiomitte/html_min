# TYPO3 Extension `html_min`

This extension minimizes the produced HTML to as little as possible.

A larger HTML with the size 200kb will be slimmed down to 73kb (64% less) while the transferred size will be reduced from 20.67kb to 16.96kb (18% less).

This extensions uses the package [voku/html-min](https://github.com/voku/HtmlMin), thanks for your work!

## Installation

Install this extenion by using `composer require studiomitte/html-min` and it will work out of the box.

### Configuration

The following settings can be defined in the *Install Tool > Settings*:

- `enable`: Enable/Disable the usage of the extension
- `headerComment`: If set, the header comment will be keep intact.

# About StudioMitte

This extension has been brought to you by [StudioMitte](https://studiomitte.com).

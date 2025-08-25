# About Page Block - Setup Instructions

## Overview
The About Page Block is a dynamic block that renders content from the `about_page` content type and `core_value` content type. It automatically displays all sections based on the content you create.

## Prerequisites
1. **About Page Content Type**: Must be created with all the required fields
2. **Core Value Content Type**: Must be created for the values section
3. **Content**: At least one About Page node must be created

## Content Type Fields Required

### About Page Content Type
- `field_foundation_title` - Text (plain)
- `field_foundation_description` - Text (plain, long)
- `field_foundation_image` - Image
- `field_vision_and_mission_title` - Text (plain)
- `field_vision_and_mission_descrip` - Text (plain, long)
- `field_vision_title` - Text (plain)
- `field_vision_description` - Text (plain, long)
- `field_mission_title` - Text (plain)
- `field_mission_description` - Text (plain, long)
- `field_ceo_message_title` - Text (plain)
- `field_ceo_message_description` - Text (plain, long)
- `field_ceo_message` - Text (plain, long)
- `field_ceo_name` - Text (plain)
- `field_ceo_position` - Text (plain)
- `field_ceo_image` - Image
- `field_goals_title` - Text (plain)
- `field_goals_description` - Text (plain, long)
- `field_strategic_goals` - Text (plain, long)
- `field_value_title` - Text (plain)
- `field_value_description` - Text (plain, long)
- `field_center_role_title` - Text (plain)
- `field_center_role_description` - Text (plain, long)
- `field_missions_title` - Text (plain)
- `field_missions_description` - Text (plain, long)
- `field_missions_list` - Text (plain, long)

### Core Value Content Type
- `field_value_title` - Text (plain)
- `field_value_description` - Text (plain, long)
- `field_value_icon` - Image
- `field_display_order` - Number (integer)

## Setup Steps

### 1. Create Content Types
Create the content types as specified above in the Drupal admin interface.

### 2. Create Content
1. **Create one About Page node** with all the content you want to display
2. **Create multiple Core Value nodes** for each value you want to display
   - Set the `field_display_order` to control the order (lower numbers appear first)

### 3. Place the Block
1. Go to **Structure > Block layout**
2. Click **Place block** in the desired region
3. Search for "About Page Content" block
4. Place it and configure the region as needed

### 4. Configure Block Settings
- **Title**: Set the block title (optional)
- **Region**: Choose where to display the block
- **Visibility**: Configure when the block should be visible

## Features

### Dynamic Content
- All content is pulled from the database
- No hardcoded text
- Fully translatable

### Responsive Design
- Mobile-friendly navigation
- Responsive grid layouts
- Optimized for all screen sizes

### Navigation
- Sticky sidebar navigation
- Smooth scrolling to sections
- Active state highlighting

### Content Sections
- **Foundation**: Establishment information with image
- **Vision & Mission**: Two-column card layout
- **CEO Message**: Quote with CEO image and details
- **Strategic Goals**: Numbered list of goals
- **Values**: Grid of value cards with icons
- **Center Role**: Description of center's role
- **Missions**: Bullet-point list of missions

## Customization

### Styling
- CSS styles are located in your `ncim_theme` theme
- Modify colors, spacing, and layout as needed in your theme's CSS files
- Uses your existing theme's styling system

### Template
- Twig template is located in `web/themes/custom/ncim_theme/templates/blocks/about-page-content.html.twig`
- Modify the HTML structure as needed in your theme
- All text uses the `|t` filter for translation
- Static icons use `/{{ directory }}/images/icons/` for proper Drupal theme paths

### Unlimited Text Fields
- `field_strategic_goals` and `field_missions_list` are unlimited text fields
- Users can add/remove items dynamically
- Each item is displayed on a new line
- The block automatically handles multiple values and converts them to line-separated lists

### Icons
- Vision and Mission icons are hardcoded in the template
- Value icons are dynamic from the `core_value` content type
- CEO and Foundation images are dynamic from the `about_page` content type

## Troubleshooting

### Block Not Displaying
1. Check if the About Page node exists and is published
2. Verify the block is placed in a visible region
3. Check block visibility settings

### Content Not Showing
1. Verify all required fields have content
2. Check field permissions
3. Ensure content is in the current language

### Styling Issues
1. Clear Drupal cache
2. Check if CSS file is loading
3. Verify CSS selectors match the HTML structure

## Support
For issues or questions, check the module's issue queue or contact the development team.

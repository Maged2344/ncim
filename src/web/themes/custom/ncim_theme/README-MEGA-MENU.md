# Dynamic Mega Menu Setup Guide

## 🎯 **What We've Implemented:**

Your mega menu is now dynamic and pulls data from Drupal's main menu system. The `ncim_theme_main_menu` block will automatically render using your custom templates.

## 🚀 **How to Set Up Your Menu Structure:**

### **Step 1: Configure the Main Menu in Drupal Admin**

1. Go to **Structure > Menus > Main menu**
2. Create your menu structure like this:

```
الرئيسية (Home)
├── عن المركز (About Center)
│   ├── عن المركز (About Center)
│   │   ├── نبذة عن المركز (Center Overview)
│   │   └── الهيكل التنظيمي (Organizational Structure)
│   ├── من نخدم (Who We Serve)
│   │   ├── أصحاب العمل والأفراد (Business Owners & Individuals)
│   │   └── الجهات الحكومية والمنفذة (Government Entities)
│   ├── الأنظمة والمصطلحات (Regulations & Terms)
│   │   ├── الأنظمة واللوائح (Regulations & Bylaws)
│   │   └── المصطلحات (Terms)
│   └── الشفافية والحوكمة (Transparency & Governance)
│       ├── التقارير السنوية (Annual Reports)
│       ├── سياسة الخصوصية (Privacy Policy)
│       └── حرية الحصول على المعلومات (Freedom of Information)
├── الأخبار والأحداث (News & Events)
├── الخدمات (Services)
├── المساعدة والدعم (Help & Support)
└── تواصل معنا (Contact Us)
```

### **Step 2: Add Icons to Menu Items (Optional)**

To add custom icons to menu items:

1. Edit a menu link in **Structure > Menus > Main menu**
2. In the "Link" section, add a custom attribute:
   - **Title**: `icon`
   - **Value**: `your-icon-name.svg` (without the full path)

The icon should be placed in `web/themes/custom/ncim_theme/images/icons/`

### **Step 3: Test the Menu**

1. Clear Drupal's cache: `drush cr`
2. Visit your site to see the dynamic mega menu
3. The menu should now pull content from Drupal's menu system

## 🔧 **How It Works:**

- **`menu--main.html.twig`**: Renders the entire navigation structure
- **`menu-item--main.html.twig`**: Renders individual menu items with mega menu support
- **The `ncim_theme_main_menu` block**: Automatically uses these templates

## 📁 **Files Created:**

1. `templates/navigation/menu--main.html.twig` - Main menu wrapper
2. `templates/navigation/menu-item--main.html.twig` - Menu item template
3. `templates/includes/navigation.html.twig` - Updated to use the block

## ❓ **Troubleshooting:**

### **Menu Not Showing:**
1. Check if you have menu items in **Structure > Menus > Main menu**
2. Verify the `ncim_theme_main_menu` block is placed in the primary menu region
3. Clear Drupal's cache

### **Styling Issues:**
1. Ensure your CSS classes are still applied
2. Check that Bootstrap 5 is properly loaded
3. Verify the theme is active

### **Icons Not Showing:**
1. Check that icon files exist in the correct directory
2. Verify the icon attribute is set correctly on menu links
3. Check file permissions

## 🎨 **Customization:**

- **Modify `menu--main.html.twig`** to change the overall structure
- **Modify `menu-item--main.html.twig`** to change individual item rendering
- **Add CSS** to customize the appearance
- **Configure menu items** through Drupal admin

## ✅ **Benefits:**

- ✅ **Fully Dynamic**: Menu structure managed through Drupal admin
- ✅ **No Hardcoding**: All content comes from the menu system
- ✅ **Easy Maintenance**: Content editors can update without touching code
- ✅ **Same Design**: Maintains your existing styling and layout
- ✅ **Performance**: Uses Drupal's built-in caching and optimization

Your mega menu is now dynamic and will automatically update when you add, remove, or modify menu items in Drupal's admin interface!

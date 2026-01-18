# Missing translation keys (draft)

Found many hard-coded strings in Blade views & JS under `resources/views` and `public/asset/js`. Below are the most common UI strings I will convert to translation keys and add to `resources/lang/{sw,ar}/ui.php` as a draft. Please confirm if you want me to proceed to apply these automatically.

## Common buttons / actions
- btn.submit -> Submit
  - sw: "Wasilisha"  | ar: "إرسال"
- btn.save -> Save
  - sw: "Hifadhi"     | ar: "حفظ"
- btn.cancel -> Cancel
  - sw: "Ghairi"      | ar: "إلغاء"
- btn.edit -> Edit
  - sw: "Hariri"      | ar: "تعديل"
- btn.delete -> Delete
  - sw: "Futa"        | ar: "حذف"
- btn.previous -> Previous
  - sw: "Iliyopita"   | ar: "السابق"
- btn.next -> Next
  - sw: "Ifuatayo"    | ar: "التالي"
- btn.saveExit -> Save & Exit
  - sw: "Hifadhi na Toka" | ar: "حفظ وخروج"

## Navigation / Pages
- nav.dashboard -> Dashboard
  - sw: "Dashibodi"   | ar: "لوحة القيادة"
- nav.nikah -> Register Nikah
  - sw: "Sajili Nikah" | ar: "تسجيل النكاح"
- nav.invoices -> Invoices
  - sw: "Ankara"      | ar: "الفواتير"
- nav.print -> Print
  - sw: "Chapisha"    | ar: "طباعة"

## Forms / Labels
- label.search_placeholder -> Search...
  - sw: "Tafuta..."    | ar: "ابحث..."
- label.application_id -> Application ID:
  - sw: "Nambari ya Maombi:" | ar: "رقم الطلب:"
- review.title -> REVIEW THE INFORMATION BEFORE YOU SUBMIT
  - sw: "KAGUA TAARIFA KABLA YA KUTUMA" | ar: "راجع البيانات قبل الإرسال"

## Admin templates / Invoice texts
- invoice.title -> Invoice
  - sw: "Ankara"      | ar: "فاتورة"
- invoice.to -> Invoice To:
  - sw: "Ankara Kwa:" | ar: "فاتورة إلى:"
- invoice.message_sample -> "We have generated a new invoice in the amount of $95.59"
  - sw: "Tumeunda ankara mpya ya $95.59" | ar: "لقد أنشأنا فاتورة جديدة بمبلغ $95.59"

---

Next step (if you approve):
1) I will add the keys above to `resources/lang/sw/ui.php` and `resources/lang/ar/ui.php` (draft machine translations),
2) Replace the literal strings in the most-used views (landing, nikah form, admin invoice pages, admin lists) with `__('ui.key')` or `data-i18n` for JS where appropriate,
3) Run a pass to find remaining strings and repeat.

Please reply with: "Proceed with automatic translation" or "Only make change list" or any other instruction.
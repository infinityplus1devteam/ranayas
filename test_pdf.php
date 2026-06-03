try { \ = App\Model\TxnOrder::whereHas('user')->first(); \ =
\Barryvdh\DomPDF\Facade\Pdf::loadView('backend.admin.invoices.download', ['invoice' => \]); echo 'PDF generated
successfully'; } catch (\Exception \) { echo \->getMessage(); }
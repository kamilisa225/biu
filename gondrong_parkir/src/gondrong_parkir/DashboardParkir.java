package gondrong_parkir;
import javax.swing.table.DefaultTableModel;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import javax.swing.JOptionPane;
public class DashboardParkir extends javax.swing.JFrame {

    static void refreshTable() {
        throw new UnsupportedOperationException("Not supported yet."); 
    }
    public DashboardParkir() {
        initComponents();
        loadDataFromDatabase();
    }
    void loadDataFromDatabase() {
        DefaultTableModel model = (DefaultTableModel) tableparkir.getModel();
        model.setRowCount(0);

        try (Connection conn = DatabaseConnection.getConnection()) {
            String sql = "SELECT * FROM data_parkir";
            PreparedStatement stmt = conn.prepareStatement(sql);
            ResultSet rs = stmt.executeQuery();

            // Sesuaikan kolom dengan struktur tabel data_parkir Anda
            while (rs.next()) {
                Object[] row = {
                    rs.getString("plat_nomor"),
                    rs.getString("tipe_merk"),
                    rs.getString("waktu_masuk"),
                    rs.getString("waktu_keluar")
                };
                model.addRow(row);
            }
        } catch (SQLException e) {
            javax.swing.JOptionPane.showMessageDialog(this, 
                "Error loading data: " + e.getMessage(), 
                "Database Error", 
                javax.swing.JOptionPane.ERROR_MESSAGE);
        }
    }
    
    private int hitungBiayaParkir(String waktuMasukStr)  {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        try {
            Date waktuMasuk = sdf.parse(waktuMasukStr);
            Date waktuKeluar = new Date();

            long diffInMillis = waktuKeluar.getTime() - waktuMasuk.getTime();
            long diffInHours = diffInMillis / (60 * 60 * 1000);

            if (diffInHours <= 12) {
                return 3000; // 3k untuk 12 jam pertama
            } else {
                long diffInDays = diffInHours / 24;
                if (diffInHours % 24 != 0) diffInDays++; // pembulatan ke atas
                return (int) (diffInDays * 5000); // 5k per hari
            }
        } catch (ParseException e) {
            JOptionPane.showMessageDialog(this, 
                "Format waktu tidak valid", "Error", JOptionPane.ERROR_MESSAGE);
            return 0;
        }
    }
    
    private void simpanKeRekap(String plat_nomor, int biayaParkir) {
    try (Connection conn = DatabaseConnection.getConnection()) {
        String sql = "INSERT INTO rekap_parkir (tanggal, jml_kendaraan_masuk, pemasukan) " +
                     "VALUES (CURDATE(), 1, ?) " +
                     "ON DUPLICATE KEY UPDATE " +
                     "jml_kendaraan_masuk = jml_kendaraan_masuk + 1, " +
                     "pemasukan = pemasukan + ?";
        
        PreparedStatement stmt = conn.prepareStatement(sql);
        stmt.setInt(1, biayaParkir);
        stmt.setInt(2, biayaParkir);
        stmt.executeUpdate();
    } catch (SQLException e) {
        JOptionPane.showMessageDialog(this, 
            "Error menyimpan rekap: " + e.getMessage(), 
            "Error", JOptionPane.ERROR_MESSAGE);
    }
}
    
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jScrollPane1 = new javax.swing.JScrollPane();
        tableparkir = new javax.swing.JTable();
        btntambah = new javax.swing.JButton();
        btnedit = new javax.swing.JButton();
        btnhapus = new javax.swing.JButton();
        btnsegar = new javax.swing.JButton();
        btnkeluar = new javax.swing.JButton();
        btnkembali = new javax.swing.JButton();
        btncek = new javax.swing.JButton();
        btnkelolaakun = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        tableparkir.setModel(new javax.swing.table.DefaultTableModel(
            new Object [][] {
                {null, null, null, null},
                {null, null, null, null},
                {null, null, null, null},
                {null, null, null, null}
            },
            new String [] {
                "Nomor Polisi", "Tipe / Merk", "Jam Masuk", "Jam Keluar"
            }
        ));
        jScrollPane1.setViewportView(tableparkir);

        btntambah.setText("Tambah");
        btntambah.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btntambahActionPerformed(evt);
            }
        });

        btnedit.setText("Edit");
        btnedit.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btneditActionPerformed(evt);
            }
        });

        btnhapus.setText("Hapus");
        btnhapus.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnhapusActionPerformed(evt);
            }
        });

        btnsegar.setText("Segarkan");
        btnsegar.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnsegarActionPerformed(evt);
            }
        });

        btnkeluar.setText("Set Keluar");
        btnkeluar.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnkeluarActionPerformed(evt);
            }
        });

        btnkembali.setText("Kembali");
        btnkembali.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnkembaliActionPerformed(evt);
            }
        });

        btncek.setText("Cek Rekap/Pemasukan");
        btncek.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btncekActionPerformed(evt);
            }
        });

        btnkelolaakun.setText("Kelola Akun");
        btnkelolaakun.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnkelolaakunActionPerformed(evt);
            }
        });

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(14, 14, 14)
                        .addComponent(jScrollPane1))
                    .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                        .addContainerGap()
                        .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addComponent(btnedit)
                            .addComponent(btnkembali))
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 29, Short.MAX_VALUE)
                        .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(layout.createSequentialGroup()
                                .addComponent(btnhapus)
                                .addGap(54, 54, 54)
                                .addComponent(btnkeluar)
                                .addGap(41, 41, 41)
                                .addComponent(btntambah))
                            .addComponent(btncek))
                        .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(layout.createSequentialGroup()
                                .addGap(35, 35, 35)
                                .addComponent(btnsegar))
                            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                                .addComponent(btnkelolaakun)))))
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                .addGap(27, 27, 27)
                .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 174, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 37, Short.MAX_VALUE)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(btncek)
                    .addComponent(btnkembali)
                    .addComponent(btnkelolaakun))
                .addGap(30, 30, 30)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(btnsegar)
                    .addComponent(btntambah)
                    .addComponent(btnkeluar)
                    .addComponent(btnhapus)
                    .addComponent(btnedit))
                .addGap(20, 20, 20))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void btntambahActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btntambahActionPerformed
        TambahParkir tambahForm = new TambahParkir(this);
        tambahForm.setVisible(true);
    }//GEN-LAST:event_btntambahActionPerformed

    private void btnhapusActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnhapusActionPerformed
        int selectedRow = tableparkir.getSelectedRow();

            // Validasi apakah ada row yang dipilih
            if (selectedRow == -1) {
                JOptionPane.showMessageDialog(this, 
                    "Pilih data yang akan dihapus terlebih dahulu", 
                    "Peringatan", 
                    JOptionPane.WARNING_MESSAGE);
                return;
            }

            // Dapatkan plat nomor dan waktu keluar dari row yang dipilih
            String platNomor = (String) tableparkir.getValueAt(selectedRow, 0);
            String waktuKeluar = (String) tableparkir.getValueAt(selectedRow, 3); // Asumsi kolom 3 adalah waktu_keluar

            // Validasi jika kendaraan sudah keluar
            if (waktuKeluar != null && !waktuKeluar.isEmpty()) {
                JOptionPane.showMessageDialog(this, 
                    "Data tidak bisa dihapus karena kendaraan sudah tercatat keluar", 
                    "Peringatan", 
                    JOptionPane.WARNING_MESSAGE);
                return;
            }

            // Konfirmasi penghapusan
            int confirm = JOptionPane.showConfirmDialog(
                this, 
                "Yakin ingin menghapus data dengan plat nomor " + platNomor + "?", 
                "Konfirmasi Hapus", 
                JOptionPane.YES_NO_OPTION);

            if (confirm == JOptionPane.YES_OPTION) {
                try (Connection conn = DatabaseConnection.getConnection()) {
                    // Hapus dari database
                    String sql = "DELETE FROM data_parkir WHERE plat_nomor = ? AND waktu_keluar IS NULL";
                    PreparedStatement stmt = conn.prepareStatement(sql);
                    stmt.setString(1, platNomor);

                    int rowsDeleted = stmt.executeUpdate();

                    if (rowsDeleted > 0) {
                        // Hapus dari JTable
                        ((DefaultTableModel)tableparkir.getModel()).removeRow(selectedRow);
                        JOptionPane.showMessageDialog(this, "Data berhasil dihapus");
                    } else {
                        JOptionPane.showMessageDialog(this, 
                            "Gagal menghapus data. Mungkin data sudah dihapus atau kendaraan sudah keluar.", 
                            "Error", 
                            JOptionPane.ERROR_MESSAGE);
                    }
                } catch (SQLException e) {
                    JOptionPane.showMessageDialog(this, 
                        "Gagal menghapus data: " + e.getMessage(), 
                        "Error", 
                        JOptionPane.ERROR_MESSAGE);
                }
            }
    }//GEN-LAST:event_btnhapusActionPerformed

    private void btneditActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btneditActionPerformed
        int selectedRow = tableparkir.getSelectedRow();
    
        if (selectedRow == -1) {
            JOptionPane.showMessageDialog(this, 
                "Pilih data yang akan diedit terlebih dahulu", 
                "Peringatan", 
                JOptionPane.WARNING_MESSAGE);
            return;
        }

        // Ambil data dari tabel
        String platNomor = tableparkir.getValueAt(selectedRow, 0).toString();
        String tipeMerk = tableparkir.getValueAt(selectedRow, 1).toString();

        // Buka form edit dengan data yang dipilih
        EditParkir editForm = new EditParkir(this, platNomor, tipeMerk);
        editForm.setVisible(true);
    }//GEN-LAST:event_btneditActionPerformed

    private void btnsegarActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnsegarActionPerformed
        loadDataFromDatabase();
        JOptionPane.showMessageDialog(this, "Data telah diperbarui");
    }//GEN-LAST:event_btnsegarActionPerformed

    private void btnkeluarActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnkeluarActionPerformed
        int selectedRow = tableparkir.getSelectedRow();
        if (selectedRow == -1) {
            JOptionPane.showMessageDialog(this, 
                "Pilih data kendaraan yang akan di-set keluar", 
                "Peringatan", JOptionPane.WARNING_MESSAGE);
            return;
        }

        String platNomor = (String) tableparkir.getValueAt(selectedRow, 0);
        String waktuKeluar = (String) tableparkir.getValueAt(selectedRow, 3);

        if (waktuKeluar != null && !waktuKeluar.isEmpty()) {
            JOptionPane.showMessageDialog(this, 
                "Kendaraan ini sudah tercatat keluar sebelumnya", 
                "Peringatan", JOptionPane.WARNING_MESSAGE);
            return;
        }

        String waktuMasuk = (String) tableparkir.getValueAt(selectedRow, 2);
        int biayaParkir = hitungBiayaParkir(waktuMasuk);

        // Tampilkan dialog biaya
        JOptionPane.showMessageDialog(this, 
            "Biaya parkir untuk " + platNomor + ": Rp" + biayaParkir,
            "Pembayaran Parkir", JOptionPane.INFORMATION_MESSAGE);

        // Update database
        try (Connection conn = DatabaseConnection.getConnection()) {
            // Update waktu keluar
            String sqlUpdate = "UPDATE data_parkir SET waktu_keluar = NOW() WHERE plat_nomor = ?";
            PreparedStatement stmt = conn.prepareStatement(sqlUpdate);
            stmt.setString(1, platNomor);
            stmt.executeUpdate();

            // Update tampilan tabel
            tableparkir.setValueAt(new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(new Date()), selectedRow, 3);

            // Simpan ke rekap
            simpanKeRekap(platNomor, biayaParkir);

        } catch (SQLException e) {
            JOptionPane.showMessageDialog(this, 
                "Error database: " + e.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
        }
    }//GEN-LAST:event_btnkeluarActionPerformed

    private void btnkembaliActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnkembaliActionPerformed
        Login login = new Login();
        login.setVisible(true);
        this.dispose();        
    }//GEN-LAST:event_btnkembaliActionPerformed

    private void btnkelolaakunActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnkelolaakunActionPerformed
        KelolaAkun KelolaAkun = new KelolaAkun();
        KelolaAkun.setVisible(true);
        this.dispose();  
    }//GEN-LAST:event_btnkelolaakunActionPerformed

    private void btncekActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btncekActionPerformed
        Rekap Rekap = new Rekap();
        Rekap.setVisible(true);
        this.dispose(); 
    }//GEN-LAST:event_btncekActionPerformed

    public static void main(String args[]) {
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(DashboardParkir.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(DashboardParkir.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(DashboardParkir.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(DashboardParkir.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>
        //</editor-fold>

        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new DashboardParkir().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton btncek;
    private javax.swing.JButton btnedit;
    private javax.swing.JButton btnhapus;
    private javax.swing.JButton btnkelolaakun;
    private javax.swing.JButton btnkeluar;
    private javax.swing.JButton btnkembali;
    private javax.swing.JButton btnsegar;
    private javax.swing.JButton btntambah;
    private javax.swing.JScrollPane jScrollPane1;
    private javax.swing.JTable tableparkir;
    // End of variables declaration//GEN-END:variables
}

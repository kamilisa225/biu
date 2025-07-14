package gondrong_parkir;

import javax.swing.*;
import java.sql.*;

public class EditParkir extends javax.swing.JFrame {
    
    private DashboardParkir parent;
    private String platNomorAsli;
    
    public EditParkir(DashboardParkir parent, String platNomor, String tipeMerk) {
        this.parent = parent;
        this.platNomorAsli = platNomor;
        initComponents();
        
        // Set nilai awal form
        txtnopol.setText(platNomor);
        txttipe.setText(tipeMerk);
        
        setLocationRelativeTo(parent); 
    }
    
    public EditParkir() {
        initComponents();
    }

    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jPanel1 = new javax.swing.JPanel();
        jLabel1 = new javax.swing.JLabel();
        txtnopol = new javax.swing.JTextField();
        jLabel2 = new javax.swing.JLabel();
        jLabel3 = new javax.swing.JLabel();
        txttipe = new javax.swing.JTextField();
        btnsimpan = new javax.swing.JButton();
        btnbatal = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        jLabel1.setText("Masukan Data Kendaraan Terbaru");

        txtnopol.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                txtnopolActionPerformed(evt);
            }
        });

        jLabel2.setText("No. Polisi");

        jLabel3.setText("Tipe/Merk");

        txttipe.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                txttipeActionPerformed(evt);
            }
        });

        btnsimpan.setText("Simpan");
        btnsimpan.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnsimpanActionPerformed(evt);
            }
        });

        btnbatal.setText("Batal");
        btnbatal.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnbatalActionPerformed(evt);
            }
        });

        javax.swing.GroupLayout jPanel1Layout = new javax.swing.GroupLayout(jPanel1);
        jPanel1.setLayout(jPanel1Layout);
        jPanel1Layout.setHorizontalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel1Layout.createSequentialGroup()
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addGroup(jPanel1Layout.createSequentialGroup()
                        .addGap(104, 104, 104)
                        .addComponent(jLabel1))
                    .addGroup(jPanel1Layout.createSequentialGroup()
                        .addGap(68, 68, 68)
                        .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(jPanel1Layout.createSequentialGroup()
                                .addComponent(btnbatal)
                                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                                .addComponent(btnsimpan))
                            .addGroup(jPanel1Layout.createSequentialGroup()
                                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                                    .addComponent(jLabel3)
                                    .addComponent(jLabel2))
                                .addGap(33, 33, 33)
                                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                                    .addComponent(txtnopol)
                                    .addComponent(txttipe, javax.swing.GroupLayout.DEFAULT_SIZE, 93, Short.MAX_VALUE))))))
                .addContainerGap(119, Short.MAX_VALUE))
        );
        jPanel1Layout.setVerticalGroup(
            jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel1Layout.createSequentialGroup()
                .addGap(26, 26, 26)
                .addComponent(jLabel1)
                .addGap(26, 26, 26)
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(txtnopol, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jLabel2))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jLabel3)
                    .addComponent(txttipe, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 80, Short.MAX_VALUE)
                .addGroup(jPanel1Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(btnsimpan)
                    .addComponent(btnbatal))
                .addGap(70, 70, 70))
        );

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(jPanel1, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(jPanel1, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void txtnopolActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_txtnopolActionPerformed
        txttipe.requestFocusInWindow();
    }//GEN-LAST:event_txtnopolActionPerformed

    private void txttipeActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_txttipeActionPerformed
        btnsimpan.requestFocusInWindow();
    }//GEN-LAST:event_txttipeActionPerformed

    private void btnsimpanActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnsimpanActionPerformed
        try {
            // 1. Ambil nilai dari form
            String platBaru = txtnopol.getText().trim().toUpperCase();
            String tipeBaru = txttipe.getText().trim();

            // 2. Validasi input
            if (platBaru.isEmpty() || tipeBaru.isEmpty()) {
                JOptionPane.showMessageDialog(this, 
                    "Nomor polisi dan tipe merk harus diisi!", 
                    "Error Validasi", 
                    JOptionPane.ERROR_MESSAGE);
                return;
            }

            // 3. Dapatkan koneksi database
            Connection conn = DatabaseConnection.getConnection();

            // 4. Cek apakah plat nomor diubah
            if (!platBaru.equals(this.platNomorAsli)) {
                // 5. Cek duplikat plat nomor baru
                String cekSQL = "SELECT COUNT(*) FROM data_parkir WHERE plat_nomor = ?";
                PreparedStatement cekStmt = conn.prepareStatement(cekSQL);
                cekStmt.setString(1, platBaru);

                ResultSet hasil = cekStmt.executeQuery();
                if (hasil.next() && hasil.getInt(1) > 0) {
                    JOptionPane.showMessageDialog(this, 
                        "Nomor polisi sudah digunakan kendaraan lain!", 
                        "Error Duplikat", 
                        JOptionPane.ERROR_MESSAGE);
                    return;
                }
            }

            // 6. Update data di database
            String updateSQL = "UPDATE data_parkir SET plat_nomor = ?, tipe_merk = ? WHERE plat_nomor = ?";
            PreparedStatement updateStmt = conn.prepareStatement(updateSQL);
            updateStmt.setString(1, platBaru);
            updateStmt.setString(2, tipeBaru);
            updateStmt.setString(3, this.platNomorAsli); // Gunakan variabel instance

            // 7. Eksekusi update
            int barisTerupdate = updateStmt.executeUpdate();

            if (barisTerupdate > 0) {
                JOptionPane.showMessageDialog(this, 
                    "Data kendaraan berhasil diperbarui!", 
                    "Sukses", 
                    JOptionPane.INFORMATION_MESSAGE);

                // 8. Refresh data di dashboard
                parent.loadDataFromDatabase();

                // 9. Tutup form edit
                this.dispose();
            } else {
                JOptionPane.showMessageDialog(this, 
                    "Gagal memperbarui data. Kemungkinan:\n" +
                    "- Data sudah dihapus\n" + 
                    "- Koneksi database bermasalah", 
                    "Error Update", 
                    JOptionPane.ERROR_MESSAGE);
            }

        } catch(SQLException ex) {
            JOptionPane.showMessageDialog(this, 
                "Error database: " + ex.getMessage(), 
                "Error Sistem", 
                JOptionPane.ERROR_MESSAGE);
            ex.printStackTrace();
        }
    }//GEN-LAST:event_btnsimpanActionPerformed

    private void btnbatalActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnbatalActionPerformed
        this.dispose();
    }//GEN-LAST:event_btnbatalActionPerformed

    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        /* Set the Nimbus look and feel */
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
            java.util.logging.Logger.getLogger(EditParkir.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(EditParkir.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(EditParkir.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(EditParkir.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new EditParkir().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton btnbatal;
    private javax.swing.JButton btnsimpan;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JPanel jPanel1;
    private javax.swing.JTextField txtnopol;
    private javax.swing.JTextField txttipe;
    // End of variables declaration//GEN-END:variables
}

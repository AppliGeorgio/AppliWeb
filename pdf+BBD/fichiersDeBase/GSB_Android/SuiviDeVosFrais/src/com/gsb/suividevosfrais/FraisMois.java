package com.gsb.suividevosfrais;

import java.io.Serializable;
import java.util.ArrayList;

/**
 * Classe métier contenant les informations des frais d'un mois
 *
 */
public class FraisMois implements Serializable {

	private Integer mois ; // mois concerné
	private Integer annee ; // année concernée
	private Integer etape ; // nombre d'étapes du mois
	private Integer km ; // nombre de km du mois
	private Integer nuitee ; // nombre de nuitées du mois
	private Integer repas ; // nombre de repas du mois
	private ArrayList<FraisHf> lesFraisHf ; // liste des frais hors forfait du mois
	
	public FraisMois(Integer annee, Integer mois) {
		this.annee = annee ;
		this.mois = mois ;
		this.etape = 0 ;
		this.km = 0 ;
		this.nuitee = 0 ;
		this.repas = 0 ;
		lesFraisHf = new ArrayList<FraisHf>() ;
	}

	/**
	 * Ajout d'un frais hors forfait
	 * @param montant
	 * @param motif
	 */
	public void addFraisHf(Integer montant, String motif, Integer jour) {
		lesFraisHf.add(new FraisHf(montant, motif, jour)) ;
	}
	
	/**
	 * Suppression d'un frais hors forfait
	 * @param index
	 */
	public void supprFraisHf(Integer index) {
		lesFraisHf.remove(index) ;
	}
	
	public Integer getMois() {
		return mois;
	}

	public void setMois(Integer mois) {
		this.mois = mois;
	}

	public Integer getAnnee() {
		return annee;
	}

	public void setAnnee(Integer annee) {
		this.annee = annee;
	}

	public Integer getEtape() {
		return etape;
	}

	public void setEtape(Integer etape) {
		this.etape = etape;
	}

	public Integer getKm() {
		return km;
	}

	public void setKm(Integer km) {
		this.km = km;
	}

	public Integer getNuitee() {
		return nuitee;
	}

	public void setNuitee(Integer nuitee) {
		this.nuitee = nuitee;
	}

	public Integer getRepas() {
		return repas;
	}

	public void setRepas(Integer repas) {
		this.repas = repas;
	}	
	
	public ArrayList<FraisHf> getLesFraisHf() {
		return lesFraisHf ;
	}
	
}
